<?php


namespace App\Excell;


use App\Repository\CustomerRepository;
use App\Repository\GroepRepository;
use App\Utils\Calculations;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ExcellExport {

    /**
     * @var CustomerRepository
     */
    private $customerRepository;

    /**
     * @var GroepRepository
     */
    private $groepRepository;

    /**
     * ExcellExport constructor.
     * @param CustomerRepository $customerRepository
     * @param GroepRepository $groepRepository
     */
    public function __construct(CustomerRepository $customerRepository, GroepRepository $groepRepository)
    {
        $this->customerRepository = $customerRepository;
        $this->groepRepository = $groepRepository;
    }

    public function generateRaftingExportSheetForPeriod($periodId): Spreadsheet
    {
        $week = substr($periodId, 2, 2);
        // Get 20 . year as ex: 21 => 2021
        $year = substr(date("Y"), 0, 2) . substr($periodId, 0, 2);
        $dateString = date('Y-m-d', strtotime($year . 'W' . $week));

        $lastSaturday = Calculations::getLastSaturdayFromDate($dateString);
        $nextSaturday = Calculations::getNextSaturdayFromDate($dateString);

        $customers = array_merge(
            $this->customerRepository->getAllExtraByDateWithRafting($periodId, $dateString),
            $this->customerRepository->getAllByDateWithRafting($periodId)
        );

        $spreadsheet = new Spreadsheet();

        $semana = "Semana: " . $lastSaturday . " - " . $nextSaturday;

        $worksheet = new Worksheet($spreadsheet, "Rafting " . $periodId);
        $spreadsheet->addSheet($worksheet);

        $worksheet->getCell("B1")->setValue("Rafting LifeLong Explore:")
            ->getStyle()->getFont()->setSize(20);
        $worksheet->getCell("C1")->setValue($semana)
            ->getStyle()->getFont()->setSize(20);
        $worksheet->getCell("D1")->setValue("Total: " . count($customers))
            ->getStyle()->getFont()->setSize(20);

        $worksheet->getCell("A2")->setValue("Apellido")
            ->getStyle()->getFont()->setBold(true);
        $worksheet->getCell("B2")->setValue("Nombre")
            ->getStyle()->getFont()->setBold(true);
        $worksheet->getCell("C2")->setValue("Numero dni")
            ->getStyle()->getFont()->setBold(true);
        $worksheet->getCell("D2")->setValue("Fecha de validez")
            ->getStyle()->getFont()->setBold(true);
        $worksheet->getCell("E2")->setValue("Fecha nacimiento")
            ->getStyle()->getFont()->setBold(true);
        $worksheet->getCell("F2")->setValue("Actividad")
            ->getStyle()->getFont()->setBold(true);
        $worksheet->getCell("G2")->setValue("Fecha actividad")
            ->getStyle()->getFont()->setBold(true);
        $worksheet->getCell("H2")->setValue("Agencia")
            ->getStyle()->getFont()->setBold(true);
        $worksheet->getCell("I2")->setValue("Residencia")
            ->getStyle()->getFont()->setBold(true);

        $worksheet->getColumnDimension("A")->setAutoSize(true);
        $worksheet->getColumnDimension("B")->setAutoSize(true);
        $worksheet->getColumnDimension("C")->setAutoSize(true);
        $worksheet->getColumnDimension("D")->setAutoSize(true);
        $worksheet->getColumnDimension("E")->setAutoSize(true);
        $worksheet->getColumnDimension("F")->setAutoSize(true);
        $worksheet->getColumnDimension("G")->setAutoSize(true);
        $worksheet->getColumnDimension("H")->setAutoSize(true);
        $worksheet->getColumnDimension("I")->setAutoSize(true);

        $rowIndex = 3;

        foreach ($customers as $customer)
        {
            $worksheet->getCell("A" . $rowIndex)->setValue($customer["first_name"]);
            $worksheet->getCell("B" . $rowIndex)->setValue($customer["last_name"]);
            $worksheet->getCell("C" . $rowIndex)->setValue($customer["national_register_number"]);
            $worksheet->getCell("D" . $rowIndex)->setValue($customer["expire_date"]);
            $worksheet->getCell("E" . $rowIndex)->setValue($customer["birthdate"]);
            $worksheet->getCell("F" . $rowIndex)->setValue($customer["activity_name"]);
            $worksheet->getCell("G" . $rowIndex)->setValue($customer["date"]);
            $worksheet->getCell("H" . $rowIndex)->setValue($customer["agency"]);
            $worksheet->getCell("I" . $rowIndex)->setValue($customer["location"]);
            $rowIndex ++;
        }

        //Remove default sheet
        if (!empty($customers))
        {
            $spreadsheet->removeSheetByIndex(0);
        }

        return $spreadsheet;

    }

    /**
     * @param string $year as in year number 2019 => 19
     * @return Spreadsheet
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     */
    public function generateRaftingExportSheetForYear(string $year): Spreadsheet
    {
        $customers = array_merge(
            $this->customerRepository->getAllExtraByYearWithRafting($year),
            $this->customerRepository->getAllByYearWithRafting($year)
        );

        $spreadsheet = new Spreadsheet();

        $yearText = "Year: " . $year;

        $worksheet = new Worksheet($spreadsheet, "Rafting " . $year);
        $spreadsheet->addSheet($worksheet);

        $worksheet->getCell("B1")->setValue("Rafting LifeLong Explore:")
            ->getStyle()->getFont()->setSize(20);
        $worksheet->getCell("C1")->setValue($yearText)
            ->getStyle()->getFont()->setSize(20);
        $worksheet->getCell("D1")->setValue("Total: " . count($customers))
            ->getStyle()->getFont()->setSize(20);

        $worksheet->getCell("A2")->setValue("Apellido")
            ->getStyle()->getFont()->setBold(true);
        $worksheet->getCell("B2")->setValue("Nombre")
            ->getStyle()->getFont()->setBold(true);
        $worksheet->getCell("C2")->setValue("Numero dni")
            ->getStyle()->getFont()->setBold(true);
        $worksheet->getCell("D2")->setValue("Fecha de validez")
            ->getStyle()->getFont()->setBold(true);
        $worksheet->getCell("E2")->setValue("Fecha nacimiento")
            ->getStyle()->getFont()->setBold(true);
        $worksheet->getCell("F2")->setValue("Actividad")
            ->getStyle()->getFont()->setBold(true);
        $worksheet->getCell("G2")->setValue("Fecha actividad")
            ->getStyle()->getFont()->setBold(true);
        $worksheet->getCell("H2")->setValue("Agencia")
            ->getStyle()->getFont()->setBold(true);
        $worksheet->getCell("I2")->setValue("Residencia")
            ->getStyle()->getFont()->setBold(true);
        $worksheet->getCell("J2")->setValue("ReizigerId")
            ->getStyle()->getFont()->setBold(true);

        $worksheet->getColumnDimension("A")->setAutoSize(true);
        $worksheet->getColumnDimension("B")->setAutoSize(true);
        $worksheet->getColumnDimension("C")->setAutoSize(true);
        $worksheet->getColumnDimension("D")->setAutoSize(true);
        $worksheet->getColumnDimension("E")->setAutoSize(true);
        $worksheet->getColumnDimension("F")->setAutoSize(true);
        $worksheet->getColumnDimension("G")->setAutoSize(true);
        $worksheet->getColumnDimension("H")->setAutoSize(true);
        $worksheet->getColumnDimension("I")->setAutoSize(true);
        $worksheet->getColumnDimension("J")->setAutoSize(true);

        $rowIndex = 3;

        foreach ($customers as $customer)
        {
            $worksheet->getCell("A" . $rowIndex)->setValue($customer["first_name"]);
            $worksheet->getCell("B" . $rowIndex)->setValue($customer["last_name"]);
            $worksheet->getCell("C" . $rowIndex)->setValue($customer["national_register_number"]);
            $worksheet->getCell("D" . $rowIndex)->setValue($customer["expire_date"]);
            $worksheet->getCell("E" . $rowIndex)->setValue($customer["birthdate"]);
            $worksheet->getCell("F" . $rowIndex)->setValue($customer["activity_name"]);
            $worksheet->getCell("G" . $rowIndex)->setValue($customer["date"]);
            $worksheet->getCell("H" . $rowIndex)->setValue($customer["agency"]);
            $worksheet->getCell("I" . $rowIndex)->setValue($customer["location"]);
            $worksheet->getCell("J" . $rowIndex)->setValue($customer["customer_id"]);
            $rowIndex ++;
        }

        //Remove default sheet
        if (!empty($customers))
        {
            $spreadsheet->removeSheetByIndex(0);
        }

        return $spreadsheet;

    }

    public function generateBillExportSheet($location, $period): Spreadsheet
    {

        $groups = $this->groepRepository->getAllByPeriodAndLocation($period, $location);

        $customers = [];

        foreach ($groups as $group)
        {
            $newCustomers = $this->customerRepository->getAllByGroepIdForPayments($group["id"]);
            $customers = array_merge($customers, $newCustomers);
        }

        foreach ($customers as $k => $customer)
        {
            $id = $customer['id'];
            $customerBill = $this->customerRepository->getBillByCustomerId($id);
            // Get more info from customer
            $customerExtra = $this->customerRepository->getAllForPaymentExportByCustomerId($id);
            if (is_array($customerBill) && is_array($customerExtra))
            {
                $customers[$k] = array_merge($customerBill, $customerExtra);;
            } else
            {
                //Remove invalid data
                unset($customers[$k]);
            }
        }

        $spreadsheet = new Spreadsheet();

        $location = is_null($location) ? "Overal" : $location;
        $period = is_null($period) ? "Alle periodes" : $period;

        $worksheet = new Worksheet($spreadsheet, $location . " - " . $period);
        $spreadsheet->addSheet($worksheet);

        $worksheet->getCell("A1")->setValue("ReizigerID")
            ->getStyle()->getFont()->setBold(true);
        $worksheet->getCell("B1")->setValue("DossierID")
            ->getStyle()->getFont()->setBold(true);
        $worksheet->getCell("C1")->setValue("PeriodeID")
            ->getStyle()->getFont()->setBold(true);
        $worksheet->getCell("D1")->setValue("BookerID")
            ->getStyle()->getFont()->setBold(true);
        $worksheet->getCell("E1")->setValue("Booker")
            ->getStyle()->getFont()->setBold(true);
        $worksheet->getCell("F1")->setValue("Naam")
            ->getStyle()->getFont()->setBold(true);
        $worksheet->getCell("G1")->setValue("Voornaam")
            ->getStyle()->getFont()->setBold(true);
        $worksheet->getCell("H1")->setValue("Agentschap")
            ->getStyle()->getFont()->setBold(true);
        $worksheet->getCell("I1")->setValue("Locatie")
            ->getStyle()->getFont()->setBold(true);
        $worksheet->getCell("J1")->setValue("StartdagOM")
            ->getStyle()->getFont()->setBold(true);
        $worksheet->getCell("K1")->setValue("EinddagOM")
            ->getStyle()->getFont()->setBold(true);
        $worksheet->getCell("L1")->setValue("Programma")
            ->getStyle()->getFont()->setBold(true);
        $worksheet->getCell("M1")->setValue("Logement")
            ->getStyle()->getFont()->setBold(true);
        $worksheet->getCell("N1")->setValue("Volpension")
            ->getStyle()->getFont()->setBold(true);
        $worksheet->getCell("O1")->setValue("VervoerHeenType")
            ->getStyle()->getFont()->setBold(true);
        $worksheet->getCell("P1")->setValue("GroepIndeling")
            ->getStyle()->getFont()->setBold(true);
        $worksheet->getCell("Q1")->setValue("Tot Raft")
            ->getStyle()->getFont()->setBold(true);
        $worksheet->getCell("R1")->setValue("Tot Canyon")
            ->getStyle()->getFont()->setBold(true);
        $worksheet->getCell("S1")->setValue("Tot Special")
            ->getStyle()->getFont()->setBold(true);
        $worksheet->getCell("T1")->setValue("Tot Kosten")
            ->getStyle()->getFont()->setBold(true);
        $worksheet->getCell("U1")->setValue("Beschrijving Kosten")
            ->getStyle()->getFont()->setBold(true);
        $worksheet->getCell("V1")->setValue("Betaald")
            ->getStyle()->getFont()->setBold(true);
        $worksheet->getCell("W1")->setValue("Payconiq")
            ->getStyle()->getFont()->setBold(true);

        $worksheet->getColumnDimension("A")->setAutoSize(true);
        $worksheet->getColumnDimension("B")->setAutoSize(true);
        $worksheet->getColumnDimension("C")->setAutoSize(true);
        $worksheet->getColumnDimension("D")->setAutoSize(true);
        $worksheet->getColumnDimension("E")->setAutoSize(true);
        $worksheet->getColumnDimension("F")->setAutoSize(true);
        $worksheet->getColumnDimension("G")->setAutoSize(true);
        $worksheet->getColumnDimension("H")->setAutoSize(true);
        $worksheet->getColumnDimension("I")->setAutoSize(true);
        $worksheet->getColumnDimension("J")->setAutoSize(true);
        $worksheet->getColumnDimension("K")->setAutoSize(true);
        $worksheet->getColumnDimension("L")->setAutoSize(true);
        $worksheet->getColumnDimension("M")->setAutoSize(true);
        $worksheet->getColumnDimension("N")->setAutoSize(true);
        $worksheet->getColumnDimension("O")->setAutoSize(true);
        $worksheet->getColumnDimension("P")->setAutoSize(true);
        $worksheet->getColumnDimension("Q")->setAutoSize(true);
        $worksheet->getColumnDimension("R")->setAutoSize(true);
        $worksheet->getColumnDimension("S")->setAutoSize(true);
        $worksheet->getColumnDimension("T")->setAutoSize(true);
        $worksheet->getColumnDimension("U")->setAutoSize(true);
        $worksheet->getColumnDimension("V")->setAutoSize(true);
        $worksheet->getColumnDimension("W")->setAutoSize(true);

        $rowIndex = 2;

        foreach ($customers as $customer)
        {
            $worksheet->getCell("A" . $rowIndex)->setValue($customer["customer_id"]);
            $worksheet->getCell("B" . $rowIndex)->setValue($customer["file_id"]);
            $worksheet->getCell("C" . $rowIndex)->setValue($customer["period_id"]);
            $worksheet->getCell("D" . $rowIndex)->setValue($customer["booker_id"]);
            $worksheet->getCell("E" . $rowIndex)->setValue($customer["booker"]);
            $worksheet->getCell("F" . $rowIndex)->setValue($customer["last_name"]);
            $worksheet->getCell("G" . $rowIndex)->setValue($customer["first_name"]);
            $worksheet->getCell("H" . $rowIndex)->setValue($customer["agency"]);
            $worksheet->getCell("I" . $rowIndex)->setValue($customer["location"]);
            $worksheet->getCell("J" . $rowIndex)->setValue($customer["start_day"]);
            $worksheet->getCell("K" . $rowIndex)->setValue($customer["end_day"]);
            $worksheet->getCell("L" . $rowIndex)->setValue($customer["program"]);
            $worksheet->getCell("M" . $rowIndex)->setValue($customer["lodging"]);
            $worksheet->getCell("N" . $rowIndex)->setValue($customer["all_in"]);
            $worksheet->getCell("O" . $rowIndex)->setValue($customer["travel_go"]);
            $worksheet->getCell("P" . $rowIndex)->setValue($customer["groep"]);

            $totRaft = 0;
            $totCanyon = 0;
            $totSpecial = 0;
            $specialDescriptions = [];

            foreach ($customer['options'] as $option)
            {
                if (isset($option["type"]))
                {
                    switch ($option["type"])
                    {
                        case "raft":
                            $totRaft = $option["price"];
                            break;

                        case "canyon":
                            $totCanyon = $option["price"];
                            break;
                    }
                } else
                {
                    $totSpecial += $option["price"];
                    $specialDescriptions[] = $option["name"];
                }

            }

            $specialDescription = implode(", ", $specialDescriptions);

            $worksheet->getCell("Q" . $rowIndex)->setValue($totRaft);

            $worksheet->getCell("R" . $rowIndex)->setValue($totCanyon);

            $worksheet->getCell("S" . $rowIndex)->setValue($totSpecial);

            $totalCost = 0;
            $payed = false;
            $payconiq = false;
            foreach ($customer["totals"] as $total)
            {
                if ($total["customer"] === $customer["customer"])
                {
                    $totalCost = $total["total"];
                    $payed = $total["payed"];
                    $payconiq = $total["payedPayconiq"];
                    break;
                }
            }

            $worksheet->getCell("T" . $rowIndex)->setValue($totalCost);
            $worksheet->getCell("U" . $rowIndex)->setValue($specialDescription);
            $worksheet->getCell("V" . $rowIndex)->setValue($payed);
            $worksheet->getCell("W" . $rowIndex)->setValue($payconiq);
            $rowIndex ++;
        }

        //Remove default sheet
        $spreadsheet->removeSheetByIndex(0);

        return $spreadsheet;
    }
}