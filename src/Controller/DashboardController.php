<?php

namespace App\Controller;

use App\Entity\Agency;
use App\Entity\AllInType;
use App\Entity\ExportBill;
use App\Entity\ExportRaft;
use App\Entity\Groep;
use App\Entity\Guide;
use App\Entity\Planning;
use App\Entity\SuitSize;
use App\Entity\Upload;
use App\Entity\Customer;
use App\Entity\GroupType;
use App\Entity\InsuranceType;
use App\Entity\Location;
use App\Entity\LodgingType;
use App\Entity\ProgramType;
use App\Entity\TravelType;
use App\Form\ExportBillType;
use App\Form\ExportRaftType;
use App\Form\UploadType;
use App\Logic\Calculations;
use App\Logic\Extensions;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController {

    /**
     * @Route("admin/export/rafting", name="admin_export_rafting")
     */
    public function exportRaftingAction(Request $request)
    {
        $exportRaft = new ExportRaft();
        $form = $this->createForm(ExportRaftType::class, $exportRaft);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            // $file stores the uploaded file
            /** @var UploadedFile $file */
            $date = $exportRaft->getDate();
            $periodId = Calculations::generatePeriodFromDate($date->format("Y-m-d"));

            $em = $this->getDoctrine()->getManager();

            $exportRaft->setCreatedBy($this->getUser());
            $em->persist($exportRaft);
            $em->flush();

            $spreadsheet = $this->generateRaftingExportSheet($date);

            $writer = IOFactory::createWriter($spreadsheet, "Xlsx");
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment; filename="raftingCustomers-' . $periodId . '.xlsx"');
            $writer->save("php://output");
            exit();

        }

        return $this->render('dashboard/export.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("admin/export/bill", name="admin_export_bill")
     */
    public function exportBillAction(Request $request)
    {
        $exportBill = new ExportBill();

        $locations = $this->getDoctrine()->getRepository(Location::class)->findAllAsChoicesForForm();
        $periods = $this->getDoctrine()->getRepository(Groep::class)->getAllPeriodIdsAsChoicesForForm();
        $options = [
            'periods' => $periods,
            'locations' => $locations
        ];

        $form = $this->createForm(ExportBillType::class, $exportBill, $options);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            // $file stores the uploaded file
            /** @var UploadedFile $file */
            $location = $exportBill->getLocation();
            $periodId = $exportBill->getPeriod();

            $em = $this->getDoctrine()->getManager();

            $exportBill->setCreatedBy($this->getUser());
            $em->persist($exportBill);
            $em->flush();

            $spreadsheet = $this->generateBillExportSheet($location, $periodId);

            $writer = IOFactory::createWriter($spreadsheet, "Xlsx");
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment; filename="EindAfrekening-' . $periodId . '-' . $location .'.xlsx"');
            $writer->save("php://output");
            exit();

        }

        return $this->render('dashboard/export.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("admin/bo-upload", name="admin_bo_upload")
     */
    public function boUploadAction(Request $request)
    {
        $upload = new Upload();
        $form = $this->createForm(UploadType::class, $upload);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            // $file stores the uploaded file
            /** @var UploadedFile $file */
            $file = $upload->getFile();

            $rp = $file->getRealPath();

            $spreadsheet = IOFactory::load($rp);
            $sheet = Extensions::getDynamicSheetAsArray($spreadsheet->getActiveSheet());

            //Remove headers
            array_shift($sheet);

            if (is_array($sheet))
            {
                //Mapping
                $em = $this->getDoctrine()->getManager();
                foreach ($sheet as $row)
                {
                    // Empty records bug fix
                    if (!is_null($row[40]))
                    {
                        $customer = $this->importCustomer($row);

                        if (!is_null($customer->getCustomerId()) && !is_null($customer->getPeriodId()))
                        {
                            $customerExists = $this->getDoctrine()->getRepository(Customer::class)->findByCustomerId($customer->getCustomerId());

                            if (!is_null($customerExists) || $customerExists)
                            {
                                //Update current
                                $customer = $this->importCustomer($row, $customerExists);
                            } else
                            {
                                //import
                                $em->persist($customer);
                            }
                        }
                    }

                }
                $upload->setFile($file->getClientOriginalName());
                $upload->setCreatedBy($this->getUser());

                $em->persist($upload);

                $em->flush();

                $this->addFlash(
                    'notice',
                    'Your Customers were saved!'
                );
            }

            return $this->redirect($this->generateUrl('easyadmin', array('entity' => 'Customer')));
        }

        return $this->render('dashboard/import.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("admin/planning-upload", name="admin_planning_upload")
     */
    public function planningUploadAction(Request $request)
    {
        $upload = new Upload();
        $form = $this->createForm(UploadType::class, $upload);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            // $file stores the uploaded file
            /** @var UploadedFile $file */
            $file = $upload->getFile();

            $rp = $file->getRealPath();

            $spreadsheet = IOFactory::load($rp);
            $periodId = 0;

            /**
             * Note toArray() only works on static cells, otherwise use getDynamicSheetAsArray
             */
            $guideSheet = $spreadsheet->getSheetByName('Gids-Afkorting')->toArray();

            //Remove headers
            array_shift($guideSheet);

            if (is_array($guideSheet))
            {
                //Mapping
                $em = $this->getDoctrine()->getManager();
                foreach ($guideSheet as $row)
                {
                    $guide = $this->importGuide($row);

                    $guideExists = $this->getDoctrine()->getRepository(Guide::class)->findByGuideShort($guide->getGuideShort());

                    if ((is_null($guideExists) || !$guideExists) && !is_null($guide->getGuideShort()))
                    {
                        $em->persist($guide);
                    }
                }
                $em->flush();
            }

            $groupSheet = $spreadsheet->getSheetByName('tblGroep');
            $groupSheet = Extensions::getDynamicSheetAsArray($groupSheet);

            //Remove headers
            array_shift($groupSheet);

            if (is_array($groupSheet))
            {
                //Mapping
                $em = $this->getDoctrine()->getManager();
                foreach ($groupSheet as $row)
                {
                    $groep = $this->importGroep($row);

                    if (!is_null($groep->getPeriodId()) && !is_null($groep->getLocation()))
                    {
                        $periodId = $groep->getPeriodId();
                        $location = $groep->getLocation();

                        $groepExists = null;

                        if (!is_null($location))
                        {
                            $groepExists = $this->getDoctrine()->getRepository(Groep::class)->findByGroupIdAndPeriodIdAndLocationId($groep->getGroupId(), $periodId, $location->getId());
                        }

                        if (!is_null($groepExists) || $groepExists)
                        {
                            //Update current
                            $groep = $this->importGroep($row, $groepExists);
                        }

                        if (!empty($groep->getName()))
                        {
                            //Don't add empty groeps
                            $em->persist($groep);
                        }
                    }
                }
                $em->flush();
            }

            $planningSheet = $spreadsheet->getSheetByName('tblPlanning');

            $planningSheet = Extensions::getDynamicSheetAsArray($planningSheet);

            //Remove headers
            array_shift($planningSheet);

            if (is_array($planningSheet))
            {
                //Mapping
                $em = $this->getDoctrine()->getManager();
                foreach ($planningSheet as $row)
                {
                    $planning = $this->importPlanning($row, $periodId);
                    if (!is_null($planning->getPlanningId()) && !is_null($planning->getDate()))
                    {
                        $plRep = $this->getDoctrine()->getRepository(Planning::class);

                        $planningExists = $plRep
                            ->findByPlanningIdAndDateAndGroepId($planning->getPlanningId(), $planning->getDate(), $row[15]);

                        if (!is_null($planningExists) || $planningExists)
                        {
                            //Update current
                            $planning = $this->importPlanning($row, $periodId, $plRep->find($planningExists));
                        }

                        if (!is_null($planning->getGuide()) && !empty($planning->getGuide()))
                        {
                            //Don't add empty planning
                            $em->persist($planning);
                        }
                    }
                }
            }

            $upload->setFile($file->getClientOriginalName());

            $em->persist($upload);

            $em->flush();

            $this->addFlash(
                'notice',
                'Your plannings were saved!'
            );

            return $this->redirect($this->generateUrl('easyadmin', array('entity' => 'Planning')));
        }

        return $this->render('dashboard/import.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    private function importCustomer($row, ?Customer $updateCustomer = null): Customer
    {
        if (is_null($updateCustomer))
        {
            $updateCustomer = new Customer();
        }

        $updateCustomer->setCustomerId($row[0]);
        $updateCustomer->setFileId($row[1]);
        $updateCustomer->setPeriodId($row[3]);
        $updateCustomer->setBookerId($row[4]);
        $updateCustomer->setBooker($row[5]);
        $updateCustomer->setLastName($row[6]);
        $updateCustomer->setFirstName($row[7]);
        $updateCustomer->setBirthdate(Calculations::convertExcelDateToDateTime($row[8]));
        $updateCustomer->setEmail($row[9]);
        $updateCustomer->setGsm($row[10]);
        $updateCustomer->setNationalRegisterNumber($row[11]);
        $updateCustomer->setExpireDate(Calculations::getDateOrNull($row[12], 'j/m/Y'));

        $size = $this->getDoctrine()->getRepository(SuitSize::class)->findBySizeId($row[13]);
        if ($size)
        {
            $updateCustomer->setSize($size);
        }

        $updateCustomer->setSizeInfo($row[14]);
        $updateCustomer->setNameShortage($row[15]);
        $updateCustomer->setEmergencyNumber($row[16]);
        $updateCustomer->setLicensePlate($row[17]);

        $updateCustomer->setTypePerson($row[18]);

        $updateCustomer->setInfoCustomer($row[19]);
        $updateCustomer->setInfoFile($row[20]);

        $agency = $this->getDoctrine()->getRepository(Agency::class)->findByCode($row[21]);
        if ($agency)
        {
            $updateCustomer->setAgency($agency);
        }

        $location = $this->getDoctrine()->getRepository(Location::class)->findByCode($row[22]);
        if ($location)
        {
            $updateCustomer->setLocation($location);
        }

        $updateCustomer->setStartDay(Calculations::convertExcelDateToDateTime($row[23]));
        $updateCustomer->setEndDay(Calculations::convertExcelDateToDateTime($row[24]));

        $program = $this->getDoctrine()->getRepository(ProgramType::class)->findByCode($row[25]);
        if ($program)
        {
            $updateCustomer->setProgramType($program);
        }

        $lodging = $this->getDoctrine()->getRepository(LodgingType::class)->findByCode($row[26]);
        if ($lodging)
        {
            $updateCustomer->setLodgingType($lodging);
        }

        $allIn = $this->getDoctrine()->getRepository(AllInType::class)->findByCode($row[27]);
        if ($allIn)
        {
            $updateCustomer->setAllInType($allIn);
        }

        $insuranceType = $this->getDoctrine()->getRepository(InsuranceType::class)->findByCode($row[28]);
        if ($insuranceType)
        {
            $updateCustomer->setInsuranceType($insuranceType);
        }

        $travelGo = $this->getDoctrine()->getRepository(TravelType::class)->findByCode($row[29]);
        if ($travelGo)
        {
            $updateCustomer->setTravelGoType($travelGo);
        }

        $updateCustomer->setTravelGoDate(Calculations::convertExcelDateToDateTime($row[30]));

        $travelBack = $this->getDoctrine()->getRepository(TravelType::class)->findByCode($row[31]);
        if ($travelBack)
        {
            $updateCustomer->setTravelBackType($travelBack);
        }

        $updateCustomer->setTravelBackDate(Calculations::convertExcelDateToDateTime($row[32]));

        $updateCustomer->setBoardingPoint($row[33]);

        $updateCustomer->setActivityOption($row[34]);

        $updateCustomer->setGroupName($row[35]);

        $groupType = $this->getDoctrine()->getRepository(GroupType::class)->findByCode($row[36]);
        if ($groupType)
        {
            $updateCustomer->setGroupPreference($groupType);
        }

        $updateCustomer->setLodgingLayout($row[37]);


        $group = $this->getDoctrine()->getRepository(Groep::class)->findByGroupIdAndPeriodId($row[38], $updateCustomer->getPeriodId());
        if ($group)
        {
            $updateCustomer->setGroupLayout($group);
        }

        $updateCustomer->setBookerPayed(Calculations::getStringBool($row[39]));

        $updateCustomer->setPayer($this->getDoctrine()->getRepository(Customer::class)->findByCustomerId($row[40]));

        $updateCustomer->setIsCamper(Calculations::getStringBool($row[41]));

        $updateCustomer->setPayed(Calculations::getStringBool($row[42]));

        $updateCustomer->setCheckedIn(Calculations::getStringBool($row[43]));

        $updateCustomer->setTotalExclInsurance(is_float($row[44]) ? $row[44] : 0);

        $updateCustomer->setInsuranceValue($row[45]);

        return $updateCustomer;
    }

    private function importGuide($row): Guide
    {
        $guide = new Guide();

        $guide->setGuideShort($row[0]);
        $guide->setGuideFirstName(trim($row[1]));
        $guide->setGuideLastName(trim($row[2]));

        return $guide;
    }

    private function importGroep($row, ?Groep $updateGroep = null): Groep
    {
        if (is_null($updateGroep))
        {
            $updateGroep = new Groep();
        }

        $updateGroep->setGroupIndex($row[0]);
        $updateGroep->setName($row[1]);
        $updateGroep->setPeriodId($row[2]);

        $location = $this->getDoctrine()->getRepository(Location::class)->findByCode($row[3]);
        if ($location)
        {
            $updateGroep->setLocation($location);
        }

        $updateGroep->setGroupId($row[4]);

        $agency = $this->getDoctrine()->getRepository(Agency::class)->findByCode($row[5]);
        if ($agency)
        {
            $updateGroep->setAgency($agency);
        }

        return $updateGroep;
    }

    private function importPlanning($row, $periodId, ?Planning $updatePlanning = null): Planning
    {
        if (is_null($updatePlanning))
        {
            $updatePlanning = new Planning();
        }

        $updatePlanning->setPlanningId((int) $row[0]);

        $updatePlanning->setDate(Calculations::convertExcelDateToDateTime($row[1]));
        $group = $this->getDoctrine()->getRepository(Groep::class)->findByGroupIdAndPeriodId($row[15], $periodId);
        if ($group)
        {
            $updatePlanning->setGroup($group);
        }

        $updatePlanning->setActivity($row[5]);

        $guide = $this->getDoctrine()->getRepository(Guide::class)->findByGuideShort($row[6]);
        if ($guide)
        {
            $updatePlanning->setGuide($guide);
        }

        $cag1 = $this->getDoctrine()->getRepository(Guide::class)->findByGuideShort($row[7]);
        if ($cag1)
        {
            $updatePlanning->setCag1($cag1);
        }

        $cag2 = $this->getDoctrine()->getRepository(Guide::class)->findByGuideShort($row[8]);
        if ($cag2)
        {
            $updatePlanning->setCag2($cag2);
        }

        $guideFunction = (int) $row[9];
        $updatePlanning->setGuideFunction($guideFunction);

        $updatePlanning->setTransport($row[10]);

        return $updatePlanning;
    }

    private function generateRaftingExportSheet(\DateTime $date)
    {
        $dateString = $date->format("Y-m-d");
        $lastSaturday = Calculations::getLastSaturdayFromDate($dateString);
        $nextSaturday = Calculations::getNextSaturdayFromDate($dateString);

        $periodId = Calculations::generatePeriodFromDate($dateString);

        $rep = $this->getDoctrine()->getRepository(Customer::class);

        $customers = array_merge($rep->getAllExtraByDateWithRafting($periodId, $dateString), $rep->getAllByDateWithRafting($periodId));
        $customersByDate = $this->groupCustomersByDate($customers);

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();

        foreach ($customersByDate as $date => $groupedCustomers)
        {
            $worksheet = new Worksheet($spreadsheet, substr($date, 8, 2));
            $spreadsheet->addSheet($worksheet);

            $worksheet->getCell("B1")->setValue("Rafting LifeLong Explore:")
                ->getStyle()->getFont()->setSize(20);
            $worksheet->getCell("C1")->setValue("Semana: " . $lastSaturday . " - " . $nextSaturday)
                ->getStyle()->getFont()->setSize(20);
            $worksheet->getCell("D1")->setValue($date)
                ->getStyle()->getFont()->setSize(20);
            $worksheet->getCell("E1")->setValue("Total: " . count($customersByDate[$date]))
                ->getStyle()->getFont()->setSize(20);

            $worksheet->getCell("A2")->setValue("Voornaam")
                ->getStyle()->getFont()->setBold(true);
            $worksheet->getCell("B2")->setValue("Naam")
                ->getStyle()->getFont()->setBold(true);
            $worksheet->getCell("C2")->setValue("RijksregisterNummer")
                ->getStyle()->getFont()->setBold(true);
            $worksheet->getCell("D2")->setValue("VervaldatumId")
                ->getStyle()->getFont()->setBold(true);
            $worksheet->getCell("E2")->setValue("Geboortedatum")
                ->getStyle()->getFont()->setBold(true);
            $worksheet->getCell("F2")->setValue("OptieOmschrijving")
                ->getStyle()->getFont()->setBold(true);
            $worksheet->getCell("G2")->setValue("Datum")
                ->getStyle()->getFont()->setBold(true);

            $worksheet->getColumnDimension("A")->setAutoSize(true);
            $worksheet->getColumnDimension("B")->setAutoSize(true);
            $worksheet->getColumnDimension("C")->setAutoSize(true);
            $worksheet->getColumnDimension("D")->setAutoSize(true);
            $worksheet->getColumnDimension("E")->setAutoSize(true);
            $worksheet->getColumnDimension("F")->setAutoSize(true);
            $worksheet->getColumnDimension("G")->setAutoSize(true);

            $rowIndex = 3;

            foreach ($groupedCustomers as $customer)
            {
                $worksheet->getCell("A" . $rowIndex)->setValue($customer["first_name"]);
                $worksheet->getCell("B" . $rowIndex)->setValue($customer["last_name"]);
                $worksheet->getCell("C" . $rowIndex)->setValue($customer["national_register_number"]);
                $worksheet->getCell("D" . $rowIndex)->setValue($customer["expire_date"]);
                $worksheet->getCell("E" . $rowIndex)->setValue($customer["birthdate"]);
                $worksheet->getCell("F" . $rowIndex)->setValue($customer["activity_name"]);
                $worksheet->getCell("G" . $rowIndex)->setValue($customer["date"]);
                $rowIndex ++;
            }
        }

        //Remove default sheet
        $spreadsheet->removeSheetByIndex(0);

        return $spreadsheet;

    }

    private function generateBillExportSheet($location, $period)
    {
        $rep = $this->getDoctrine()->getRepository(Groep::class);

        $groups = $rep->getAllByPeriodAndLocation($period, $location);

        $customers = [];
        $rep = $this->getDoctrine()->getRepository(Customer::class);

        foreach ($groups as $group)
        {
            $newCustomers = $rep->getAllByGroepIdForPayments($group["id"]);
            $customers = array_merge($customers, $newCustomers);
        }

        foreach ($customers as $k => $customer)
        {
            $id = $customer['id'];
            $customerBill = $rep->getBillByCustomerId($id);
            // Get more info from customer
            $customerExtra = $rep->getAllForPaymentExportByCustomerId($id);
            $customers[$k] = array_merge($customerBill, $customerExtra);;
        }

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();

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
            $specialDescription = "";

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
            foreach ($customer["totals"] as $total) {
                if ($total["customer"] === $customer["customer"]) {
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

    private function groupCustomersByDate($customers)
    {
        $customersByDate = [];
        foreach ($customers as $customer)
        {
            if (!isset($customersByDate[$customer['date']]))
            {
                $customersByDate[$customer['date']] = [];
            }

            $customersByDate[$customer['date']][] = $customer;
        }

        return $customersByDate;
    }
}
