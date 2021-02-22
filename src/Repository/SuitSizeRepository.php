<?php

namespace App\Repository;

use App\Entity\Activity;
use App\Entity\Customer;
use App\Entity\Guide;
use App\Entity\Planning;
use App\Entity\ProgramActivity;
use App\Entity\SuitSize;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SuitSize|null find($id, $lockMode = null, $lockVersion = null)
 * @method SuitSize|null findOneBy(array $criteria, array $orderBy = null)
 * @method SuitSize[]    findAll()
 * @method SuitSize[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SuitSizeRepository extends ServiceEntityRepository {

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SuitSize::class);
    }

    public function findByName($name): ?SuitSize
    {
        return $this->createQueryBuilder('e')
            ->where('e.name = :name')
            ->setParameter('name', $name)
            ->getQuery()
            ->setMaxResults(1)
            ->getOneOrNullResult();
    }

    public function findBySizeId($sizeId): ?SuitSize
    {
        return $this->createQueryBuilder('e')
            ->where('e.sizeId = :sizeId')
            ->setParameter('sizeId', $sizeId)
            ->getQuery()
            ->setMaxResults(1)
            ->getOneOrNullResult();
    }

    public function findAllRaw(): array
    {
        $connection = $this->_em->getConnection();
        $qb = $connection->createQueryBuilder();

        $qb
            ->select("sz.id, sz.name")
            ->from("suit_size", "sz");

        return $qb->execute()->fetchAllAssociative();
    }

    public function findSuitSizesFullFromDateAndGuide($date, $guideId, $locationId)
    {


        $rep = $this->getEntityManager()->getRepository(Guide::class);
        $guide = $rep->find($guideId);

        $rep = $this->getEntityManager()->getRepository(Planning::class);
        $plannings = $rep->findByGuideIdDateAndLocationId($guideId, $date, $locationId);

        $activityName = "";
        $activity = null;
        $customers = [];
        $groupName = "";
        $groupTotal = 0;

        if (!empty($plannings))
        {
            foreach ($plannings as $planning)
            {
                $planning = $rep->find($planning["id"]);
                /**
                 * @var $planning Planning
                 */
                $activityName = $planning->getActivity();
                $activityName = str_replace("o_", "", $activityName);
                $rep = $this->getEntityManager()->getRepository(Activity::class);

                $activity = $rep->findByName($activityName);

                $group = $planning->getGroup();
                if (isset($group))
                {
                    $groupName .= $group->getName() . " ";
                    $groupTotal += $group->getGroupCustomers()->count();
                    //Get all customers
                    $customers = array_merge($customers, $group->getGroupCustomers()->toArray());
                }
            }
        }

        $customersIds = [];
        $suitSizesTotals = [];
        $helmetSizesTotals = [];
        $beltSizesTotals = [];
        $userSizes = [];

        foreach ($customers as $customer)
        {
            //Filter

            // PRogram per customer
            /**
             * @var $customer Customer
             */

            $programType = $customer->getProgramType();

            $hasActivityProgramType = false;
            if (!is_null($activity) || $activity)
            {
                $rep = $this->getEntityManager()->getRepository(ProgramActivity::class);
                $hasActivityProgramType = $rep->hasProgramActivityByProgramTypeAndActivity($programType->getId(), $activity->getId());

            }

            if (!$hasActivityProgramType)
            {
                $customersIds[] = $customer->getId();
            } else
            {
                // klant gaat optioneel mee
                /*$hasOption = false;
                //Kijken of hij deze optie geboekt heeft
                if (!is_null($activity) || $activity)
                {
                    $rep = $this->getEntityManager()->getRepository(Customer::class);
                    $hasOption = $rep->hasActivityForCustomer($customer->getId(), $activity->getId());
                }

                if ($hasOption)
                {
                    $customersIds[] = $customer->getId();
                }
                */
            }

        }

        if (!empty($customersIds))
        {
            $rep = $this->getEntityManager()->getRepository(Customer::class);

            $suitSizesTotals = $rep->getSuitSizeTotalsByCustomerIds($customersIds);
            $helmetSizesTotals = $rep->getHelmetSizeTotalsByCustomerIds($customersIds);
            $beltSizesTotals = $rep->getBeltSizeTotalsByCustomerIds($customersIds);

            $userSizes = $rep->getSuitSizesByCustomerIds($customersIds);
        }

        return [
            'date' => $date,
            'guide' => [
                'short' => $guide->getGuideShort(),
                'name' => $guide->getGuideFirstName() . ' ' . $guide->getGuideLastName()
            ],
            'activity' => $activityName,
            'groupName' => $groupName,
            'groupTotal' => $groupTotal,
            'sizeTotals' => $suitSizesTotals,
            'beltTotals' => $beltSizesTotals,
            'helmetTotals' => $helmetSizesTotals,
            'userSizes' => $userSizes
        ];

    }
}
