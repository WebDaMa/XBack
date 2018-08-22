<?php

namespace App\Repository;

use App\Entity\Activity;
use App\Entity\Agency;
use App\Entity\AllInType;
use App\Entity\Customer;
use App\Entity\TravelType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class CustomerRepository extends ServiceEntityRepository {

    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Customer::class);
    }

    public function findByCustomerId($customerId): ?Customer
    {
        return $this->createQueryBuilder('e')
            ->where('e.customerId = :customerId')
            ->setParameters(['customerId' => $customerId])
            ->getQuery()
            ->setMaxResults(1)
            ->getOneOrNullResult();
    }

    public function getSuitSizesByCustomerIds(array $customerIds)
    {
        $connection = $this->_em->getConnection();
        $qb = $connection->createQueryBuilder();

        $qb
            ->select("CONCAT(c.first_name, ' ', c.last_name) AS customer", 's.name AS size',
                'c.size_info AS sizeInfo')
            ->from('customer', 'c')
            ->innerJoin('c', 'suit_size', 's', 'c.size_id = s.id')
            ->add('where', $qb->expr()->in('c.id', $customerIds));

        return $qb->execute()->fetchAll();
    }

    public function getSuitSizeTotalsByCustomerIds(array $customerIds)
    {
        $connection = $this->_em->getConnection();
        $qb = $connection->createQueryBuilder();

        $qb
            ->select('s.name AS size', 'COUNT(c.size_id) AS total')
            ->from('customer', 'c')
            ->innerJoin('c', 'suit_size', 's', 'c.size_id = s.id')
            ->groupBy('s.id')
            ->add('where', $qb->expr()->in('c.id', $customerIds));

        return $qb->execute()->fetchAll();
    }

    public function getBeltSizeTotalsByCustomerIds(array $customerIds)
    {
        $connection = $this->_em->getConnection();
        $qb = $connection->createQueryBuilder();

        $qb
            ->select('bs.name AS size', 'COUNT(c.size_id) AS total')
            ->from('customer', 'c')
            ->innerJoin('c', 'suit_size', 's', 'c.size_id = s.id')
            ->innerJoin('s', 'belt_size', 'bs', 's.belt_size_id = bs.id')
            ->groupBy('bs.id')
            ->add('where', $qb->expr()->in('c.id', $customerIds));

        return $qb->execute()->fetchAll();
    }

    public function getHelmetSizeTotalsByCustomerIds(array $customerIds)
    {
        $connection = $this->_em->getConnection();
        $qb = $connection->createQueryBuilder();

        $qb
            ->select('hs.name AS size', 'COUNT(c.size_id) AS total')
            ->from('customer', 'c')
            ->innerJoin('c', 'suit_size', 's', 'c.size_id = s.id')
            ->innerJoin('s', 'helm_size', 'hs', 's.helm_size_id = hs.id')
            ->groupBy('hs.id')
            ->add('where', $qb->expr()->in('c.id', $customerIds));

        return $qb->execute()->fetchAll();
    }

    public function getAllByGroepId($groepId)
    {
        $connection = $this->_em->getConnection();
        $qb = $connection->createQueryBuilder();

        $qb
            ->select("c.id", "CONCAT(c.first_name, ' ', c.last_name) AS customer",
                'c.size_id AS size', 'c.size_info AS sizeInfo')
            ->from('customer', 'c')
            ->where("c.group_layout_id = :groepId")
            ->orderBy("c.first_name")
            ->setParameter("groepId", $groepId);

        return $qb->execute()->fetchAll();
    }

    public function getAllByGroepIdForBill($groepId)
    {
        $connection = $this->_em->getConnection();
        $qb = $connection->createQueryBuilder();

        $qb
            ->select("c.id", "CONCAT(c.first_name, ' ', c.last_name) AS customer",
                "CONCAT(c2.first_name, ' ', c2.last_name) AS booker", 'c.payed')
            ->from('customer', 'c')
            ->innerJoin("c", "customer", "c2", "c.booker_id = c2.customer_id")
            ->where("c.group_layout_id = :groepId")
            ->orderBy("c2.first_name")
            ->setParameter("groepId", $groepId);

        $res = $qb->execute()->fetchAll();

        foreach( $res as $k => $row ) {
            if( is_null($row["payed"])) {
                $row["payed"] = false;
            }
            $row["payed"] = (boolean) $row["payed"];

            $res[$k] = $row;
        }

        return $res;
    }

    public function getAllByAgencyForLodgingAndLocationAndPeriod($agencyId, $locationId, $periodId)
    {
        $connection = $this->_em->getConnection();
        $qb = $connection->createQueryBuilder();

        $qb
            ->select("c.id", "CONCAT(c.first_name, ' ', c.last_name) AS customer",
                'l.code AS lodgingType', 'c.lodging_layout AS lodgingLayout')
            ->from('customer', 'c')
            ->innerJoin('c', "lodging_type", "l", "c.lodging_type_id = l.id")
            ->where("c.agency_id = :agencyId")
            ->andWhere("c.period_id = :periodId")
            ->andWhere("c.location_id = :locationId")
            ->setParameter("agencyId", $agencyId)
            ->setParameter("locationId", $locationId)
            ->setParameter("periodId", $periodId);

        return $qb->execute()->fetchAll();
    }

    public function getAllByGroepIdWithRaftingOption($groepId)
    {
        $connection = $this->_em->getConnection();
        $qb = $connection->createQueryBuilder();

        $qb
            ->select("c.id", "CONCAT(c.first_name, ' ', c.last_name) AS customer",
                'pt.code AS programType', "TIMESTAMPDIFF(YEAR,c.birthdate,CURDATE()) AS age",
                "a.id AS activityId")
            ->from('customer', 'c')
            ->innerJoin('c', 'program_type', 'pt', 'c.program_type_id = pt.id')
            ->leftJoin('c', 'customers_activities', 'ca', 'c.id = ca.customer_id')
            ->leftJoin('ca', 'activity', 'a', 'ca.activity_id = a.id AND a.activity_group_id = 1')
            ->where("c.group_layout_id = :groepId")
            ->setParameter("groepId", $groepId);

        return $qb->execute()->fetchAll();

    }

    public function getAllByGroepIdWithCanyoningOption($groepId)
    {
        $customers = $this->getAllByGroepIdWithProgramTypeAndNo6d($groepId);

        return $this->getActivitiesForCustomersRaw($customers, 2);

    }

    public function getAllByGroepIdWithSpecialOption($groepId)
    {
        $customers = $this->getAllByGroepIdWithProgramTypeAndNo6d($groepId);

        return $this->getActivitiesForCustomersRaw($customers, 3);

    }

    public function getAllByGroepIdWithProgramTypeAndNo6d($groepId) {
        $connection = $this->_em->getConnection();
        $qb = $connection->createQueryBuilder();

        $qb
            ->select("c.id", "CONCAT(c.first_name, ' ', c.last_name) AS customer", "c.program_type_id",
                "pt.code AS programType")
            ->from('customer', 'c')
            ->innerJoin('c', 'program_type', 'pt', 'c.program_type_id = pt.id')
            ->innerJoin('pt', 'program', 'p', 'pt.id = p.program_type_id')
            ->where("c.group_layout_id = :groepId")
            ->andWhere("p.days < 6")
            ->setParameter("groepId", $groepId);

        return $qb->execute()->fetchAll();
    }

    private function getActivitiesForCustomersRaw(array $customers, $activityGroepId) {
        $connection = $this->_em->getConnection();

        foreach ($customers as $k => $customer) {
            $customerId = $customer["id"];
            $activities = [];
            $rep = $this->getEntityManager()->getRepository(Activity::class);

            $customer["possibleActivities"] = $rep->findAllByActivityGroupIdForProgramTypeId($activityGroepId, $customer["program_type_id"]);
            unset($customer["program_type_id"]);

            if (empty($customer["possibleActivities"])) {
                // No need
                unset($customers[$k]);
                continue;
            }

            $qb = $connection->createQueryBuilder();

            $qb
                ->select("a.name")
                ->from('customers_activities', 'ca')
                ->innerJoin('ca', 'activity', 'a', 'ca.activity_id = a.id')
                ->where("ca.customer_id = :customerId")
                ->andWhere("a.activity_group_id = :activityGroupId")
                ->setParameter("customerId", $customerId)
                ->setParameter("activityGroupId", $activityGroepId);

            $rows = $qb->execute()->fetchAll();
            foreach ($rows as $row) {
                $activities[] = $row["name"];
            }
            $customer["activityIds"] = $activities;

            $customers[$k] = $customer;
        }
        return $customers;
    }

    public function getAllBusGoCustomersByDateAndTravelTypeCode($date, $travelTypeCode)
    {
        $connection = $this->_em->getConnection();
        $qb = $connection->createQueryBuilder();
        /*
         * SELECT c.bus_to_checked_in, c.gsm, c.`travel_go_date`, a.code, tg.start_point,
         * CONCAT(c.first_name, ' ', c.last_name) AS customer FROM customer c
            INNER JOIN travel_type tg ON c.`travel_go_type_id` = tg.id
            INNER JOIN agency a ON c.agency_id = a.id
            WHERE c.`travel_go_date` = '2017-04-08'
            AND tg.transport_type_id = 2
            AND tg.code = 'BUSB'
            ORDER BY customer

         */
        $qb
            ->select("c.id", "c.bus_to_checked_in AS busCheckedIn", "CONCAT(c.first_name, ' ', c.last_name) AS customer",
                'a.code AS agency', 'c.gsm')
            ->from('customer', 'c')
            ->innerJoin('c', 'travel_type', 'tg', 'c.travel_go_type_id = tg.id')
            ->innerJoin('c', 'agency', 'a', 'c.agency_id = a.id')
            ->where("c.travel_go_date = :date")
            ->andWhere('tg.code = :travelTypeCode')
            ->orderBy('customer')
            ->setParameter("date", $date)
            ->setParameter("travelTypeCode", $travelTypeCode);

        return $qb->execute()->fetchAll();
    }

    public function getAllBusBackCustomersByDateAndTravelTypeCode($date, $travelTypeCode)
    {
        $connection = $this->_em->getConnection();
        $qb = $connection->createQueryBuilder();
        $qb
            ->select("c.id", "c.bus_to_checked_in AS busCheckedIn", "CONCAT(c.first_name, ' ', c.last_name) AS customer",
                'a.code AS agency', 'c.gsm')
            ->from('customer', 'c')
            ->innerJoin('c', 'travel_type', 'tg', 'c.travel_go_type_id = tg.id')
            ->innerJoin('c', 'agency', 'a', 'c.agency_id = a.id')
            ->where("c.travel_back_date = :date")
            ->andWhere('tg.code = :travelTypeCode')
            ->orderBy('customer')
            ->setParameter("date", $date)
            ->setParameter("travelTypeCode", $travelTypeCode);

        return $qb->execute()->fetchAll();
    }

    public function getBusGoCustomersByWeek($date): array {

        return $this->getBusCustomersByWeekAndType($date, "go");
    }

    public function getBusBackCustomersByWeek($date): array {

        return $this->getBusCustomersByWeekAndType($date, "back");
    }

    public function getBusCustomersByWeekAndType($date, $type): array {
        $rep = $this->getEntityManager()->getRepository(TravelType::class);
        $busTypes = $rep->getAllBusTypes();

        $data = [
            "date" => $date,
            "total" => 0,
            "places" => []
        ];

        foreach ($busTypes as $busType) {
            /**
             * @var $busType TravelType
             */

            if($type === "go") {
                $customers = $this->getAllBusGoCustomersByDateAndTravelTypeCode($date, $busType->getCode());
            }elseif ($type === "back"){
                $customers = $this->getAllBusBackCustomersByDateAndTravelTypeCode($date, $busType->getCode());
            }

            if (!empty($customers)) {
                $data["total"] += count($customers);

                $totals = [];

                $agencies = [];
                foreach( $customers as $k => $row ) {
                    if( is_null($row["busCheckedIn"])) {
                        $row["busCheckedIn"] = false;
                    }
                    $row["busCheckedIn"] = (boolean) $row["busCheckedIn"];
                    $agencies[] = $row["agency"];

                    unset($row["agency"]);

                    $customers[$k] = $row;
                }

                if(!empty($agencies)) {
                    $agencyTotals = array_count_values( $agencies );

                    $totals = $agencyTotals;
                }

                $data["places"][] = [
                    "total" => count($customers),
                    "totals" => $totals,
                    "place" => $busType->getStartPoint(),
                    "customers" => $customers
                ];
            }

        }

        return $data;
    }

    public function hasActivityForCustomer($customerId, $activityId) : bool
    {
        $connection = $this->_em->getConnection();
        $qb = $connection->createQueryBuilder();

        $ca = $qb
            ->select("*")
            ->from('customers_activities', 'ca')
            ->where("ca.customer_id = :customerId")
            ->andWhere("ca.activity_id = :activityId")
            ->setParameter("customerId", $customerId)
            ->setParameter("activityId", $activityId)
            ->execute()->fetch();

        return is_null($ca) || $ca == false ? false : true;
    }

    public function getAllByAllInTypeForLocationAndPeriod($locationId, $periodId): array {
        $rep = $this->getEntityManager()->getRepository(AllInType::class);
        $allInTypes = $rep->findAll();

        $data = [
            "total" => 0,
            "allInTypes" => []
        ];

        $allTotals = [
            "total" => 0,
            "totals" => [],
            "allInType" => "Totaal",
            "customers" => []
        ];

        $busTotals = [
            "total" => 0,
            "totals" => [],
            "allInType" => "Met Bus",
            "customers" => []
        ];

        foreach ($allInTypes as $allInType) {
            /**
             * @var $allInType AllInType
             */

            $customers = $this->getAllByAllInTypeForLocationAndPeriodCustomers($allInType->getId(), $locationId, $periodId);

            if (!empty($customers)) {
                $data["total"] += count($customers);

                $totals = [];

                $agencies = [];
                $customerData = [];
                foreach( $customers as $row ) {
                    $agencies[] = $row["agency"];
                    if (is_null($row["hasBus"])) {
                        $row["hasBus"] = false;
                    }
                    $row["hasBus"] = (boolean) $row["hasBus"];

                    if (!isset($busTotals["totals"][$row["agency"]]))
                    {
                        $busTotals["totals"][$row["agency"]] = 0;
                    }

                    if ($row["hasBus"])
                    {
                        $busTotals["totals"][$row["agency"]] ++;
                        $busTotals["total"] ++;

                    }

                    unset($row["hasBus"]);
                    unset($row["agency"]);

                    if (!is_null($row["infoFile"]) && !empty($row["infoFile"])) {
                        $customerData[] = $row;
                    }
                }

                if(!empty($agencies)) {
                    $agencyTotals = array_count_values( $agencies );

                    foreach ($agencyTotals as $agency => $agencyTotal)
                    {
                        if(!isset($allTotals["totals"][$agency]))
                        {
                            $allTotals["totals"][$agency] = 0;
                        }
                        $allTotals["totals"][$agency] += $agencyTotal;
                        $allTotals["total"] += $agencyTotal;
                    }

                    $totals = $agencyTotals;
                }

                $data["allInTypes"][] = [
                    "total" => count($customers),
                    "totals" => $totals,
                    "allInType" => $allInType->getCode(),
                    "customers" => $customerData
                ];
            }

        }

        //Push 2 info rows
        $data["allInTypes"][] = $allTotals;
        $data["allInTypes"][] = $busTotals;

        return $data;
    }

    public function getAllByAllInTypeForLocationAndPeriodCustomers($allInTypeId, $locationId, $periodId): array {
        $connection = $this->_em->getConnection();
        $qb = $connection->createQueryBuilder();
        $qb
            ->select("c.id", "CONCAT(c.first_name, ' ', c.last_name) AS customer",
                'c.info_file AS infoFile', "ag.code AS agency",
                "(CASE WHEN tt.name = 'bus' THEN 1 ELSE 0 END) AS hasBus")
            ->from('customer', 'c')
            ->innerJoin('c', 'agency', 'ag', 'c.agency_id = ag.id')
            ->innerJoin('c', 'travel_type', 't', 'c.travel_go_type_id = t.id')
            ->innerJoin('c', 'transport_type', 'tt', 't.transport_type_id = tt.id')
            ->where("c.period_id = :periodId")
            ->andWhere("c.location_id = :locationId")
            ->andWhere("c.all_in_type_id = :allInTypeId")
            ->setParameter("locationId", $locationId)
            ->setParameter("periodId", $periodId)
            ->setParameter("allInTypeId", $allInTypeId)
            ->orderBy('customer');

        return $qb->execute()->fetchAll();
    }

    public function getAllByDateWithRafting($periodId): array {
        $connection = $this->_em->getConnection();
        $qb = $connection->createQueryBuilder();
        $qb
            ->select("c.first_name", "c.last_name", "c.national_register_number", "c.expire_date",
                "c.birthdate", "a.name AS activity_name")
            ->from('customer', 'c')
            ->innerJoin('c', 'customers_activities', 'ca', 'c.id = ca.customer_id')
            ->innerJoin('ca', 'activity', 'a', 'ca.activity_id = a.id')
            ->where("c.period_id = :periodId")
            ->andWhere("a.activity_group_id = 1")
            ->setParameter("periodId", $periodId)
            ->orderBy('a.name');

        return $qb->execute()->fetchAll();
    }
}
