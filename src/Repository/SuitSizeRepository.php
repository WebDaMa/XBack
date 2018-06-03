<?php

namespace App\Repository;

use App\Entity\Activity;
use App\Entity\Customer;
use App\Entity\Guide;
use App\Entity\Planning;
use App\Entity\ProgramActivity;
use App\Entity\SuitSize;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method SuitSize|null find($id, $lockMode = null, $lockVersion = null)
 * @method SuitSize|null findOneBy(array $criteria, array $orderBy = null)
 * @method SuitSize[]    findAll()
 * @method SuitSize[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SuitSizeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, SuitSize::class);
    }

    public function findByName($name) {
        return $this->createQueryBuilder('e')
            ->where('e.name = :name')
            ->setParameter('name',$name)
            ->getQuery()
            ->setMaxResults(1)
            ->getOneOrNullResult()
            ;
    }

    public function findBySizeId($sizeId) {
        return $this->createQueryBuilder('e')
            ->where('e.sizeId = :sizeId')
            ->setParameter('sizeId',$sizeId)
            ->getQuery()
            ->setMaxResults(1)
            ->getOneOrNullResult()
            ;
    }

    public function findSuitSizesFullFromDateAndGuide($date, $guideId) {

        $rep = $this->getEntityManager()->getRepository(Guide::class);

        $guide = $rep->find($guideId);
        $rep = $this->getEntityManager()->getRepository(Planning::class);

        $plannings = $rep->findByGuideIdAndDate($guideId, $date);

        $activityName = "";
        $customers = [];
        $groupName = "";
        $groupTotal = 0;

        if(!empty($plannings)){
            foreach ($plannings as $planning) {
                /**
                 * @var $planning Planning
                 */
                $activity = $planning->getActivity();
                if(isset($activity)) {
                    $activityName = $activity->getName();
                }
                $group = $planning->getGroup();
                if(isset($group)){
                    //TODO: some plannings don't have a activity?

                    $groupName .= $group->getName() . " ";
                    $groupTotal += $group->getGroupCustomers()->count();
                    //Get all customers
                    //TODO: check with JSc for full query

                    $customers = array_merge($customers,$group->getGroupCustomers()->toArray());
                }
            }

        }

        $customersIds = [];
        $suitSizesTotals = [];
        $helmetSizesTotals = [];
        $beltSizesTotals = [];
        $userSizes = [];

        foreach ($customers as $customer) {
            //Filter

            // PRogram per customer
            /**
             * @var $customer Customer
             */

            $programType = $customer->getProgramType();
            $activityProgramTypes = $programType->getActivityProgramTypes();

            foreach ($activityProgramTypes as $activityProgramType){
                /**
                 * @var $activityProgramType ProgramActivity
                 */

                // Vergelijken of activity in program zit

                if( $activityProgramType->getActivity()->getId() == $activity->getId()) {


                    // Indien
                    if($activityProgramType->getOptional()) {
                        // klant gaat optioneel mee

                        //Kijken of hij deze optie geboekt heeft
                        $options = $customer->getActivities();

                        foreach ($options as $option) {
                            /**
                             * @var $option Activity
                             */

                            if( $option->getId() == $activity->getId()) {
                                $customersIds[] = $customer->getId();
                            }
                        }

                    }else{
                        // Indien op 0, neem maar mee
                        $customersIds[] = $customer->getId();
                    }

                    break;
                }

            }

        }

        if(!empty($customersIds)) {
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
