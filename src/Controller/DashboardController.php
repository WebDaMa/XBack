<?php

namespace App\Controller;

use App\Entity\Agency;
use App\Entity\AllInType;
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
use App\Form\UploadType;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DashboardController extends Controller {

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
            $sheet = $spreadsheet->getActiveSheet()->toArray();

            //Remove headers
            array_shift($sheet);

            if (is_array($sheet))
            {
                //Mapping
                $em = $this->getDoctrine()->getManager();
                foreach ($sheet as $row)
                {
                    $customer = $this->importCustomer($row);

                    $em->persist($customer);
                }
                $upload->setFile($file->getClientOriginalName());

                $em->persist($upload);

                $em->flush();
            }


            return $this->redirect($this->generateUrl('admin'));
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
             *
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

                    $exists = $this->getDoctrine()->getRepository(Guide::class)->findByGuideShort($guide->getGuideShort());

                    if(is_null($exists) || !$exists) {
                        $em->persist($guide);
                    }
                }
                $em->flush();
            }

            $groupSheet = $spreadsheet->getSheetByName('tblGroep')->toArray();

            //Remove headers
            array_shift($groupSheet);

            if (is_array($groupSheet))
            {
                //Mapping
                $em = $this->getDoctrine()->getManager();
                foreach ($groupSheet as $row)
                {
                    $group = $this->importGroup($row);
                    $periodId = $group->getPeriodId();

                    $em->persist($group);
                }
                $em->flush();
            }

            $planningSheet = $spreadsheet->getSheetByName('tblPlanning');

            $planningSheet = $this->getDynamicSheetAsArray($planningSheet);

            //Remove headers
            array_shift($planningSheet);

            if (is_array($planningSheet))
            {
                //Mapping
                $em = $this->getDoctrine()->getManager();
                foreach ($planningSheet as $row)
                {
                    $planning = $this->importPlanning($row, $periodId);

                    $em->persist($planning);
                }
            }

            $upload->setFile($file->getClientOriginalName());

            $em->persist($upload);

            $em->flush();

            return $this->redirect($this->generateUrl('admin'));
        }

        return $this->render('dashboard/import.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    private function importCustomer($row): Customer
    {
        $customer = new Customer();

        $customer->setCustomerId($row[0]);
        $customer->setFileId($row[1]);
        $customer->setPeriodId($row[3]);
        $customer->setBookerId($row[4]);
        $customer->setBooker($row[5]);
        $customer->setLastName($row[6]);
        $customer->setFirstName($row[7]);
        $customer->setBirthdate($this->getDateOrNull($row[8]));
        $customer->setEmail($row[9]);
        $customer->setGsm($row[10]);
        $customer->setNationalRegisterNumber($row[11]);
        $customer->setExpireDate($this->getDateOrNull($row[12]));

        $size = $this->getDoctrine()->getRepository(SuitSize::class)->findByName($row[13]);
        if ($size)
        {
            $customer->setSize($size);
        }

        $customer->setNameShortage($row[14]);
        $customer->setEmergencyNumber($row[15]);
        $customer->setLicensePlate($row[16]);

        $customer->setTypePerson($row[17]);

        $customer->setInfoCustomer($row[18]);
        $customer->setInfoFile($row[19]);

        $agency = $this->getDoctrine()->getRepository(Agency::class)->findByCode($row[20]);
        if ($agency)
        {
            $customer->setAgency($agency);
        }

        $location = $this->getDoctrine()->getRepository(Location::class)->findByCode($row[21]);
        if ($location)
        {
            $customer->setLocation($location);
        }

        $customer->setStartDay($this->getDateOrNull($row[22]));
        $customer->setEndDay($this->getDateOrNull($row[23]));

        $program = $this->getDoctrine()->getRepository(ProgramType::class)->findByCode($row[24]);
        if ($program)
        {
            $customer->setProgramType($program);
        }

        $lodging = $this->getDoctrine()->getRepository(LodgingType::class)->findByCode($row[25]);
        if ($lodging)
        {
            $customer->setLodgingType($lodging);
        }

        $allIn = $this->getDoctrine()->getRepository(AllInType::class)->findByCode($row[26]);
        if ($allIn)
        {
            $customer->setAllInType($allIn);
        }

        $insuranceType = $this->getDoctrine()->getRepository(InsuranceType::class)->findByCode($row[27]);
        if ($insuranceType)
        {
            $customer->setInsuranceType($insuranceType);
        }

        $travelGo = $this->getDoctrine()->getRepository(TravelType::class)->findByCode($row[28]);
        if ($travelGo)
        {
            $customer->setTravelGoType($travelGo);
        }

        $customer->setTravelGoDate($this->getDateOrNull($row[29]));

        $travelBack = $this->getDoctrine()->getRepository(TravelType::class)->findByCode($row[30]);
        if ($travelBack)
        {
            $customer->setTravelBackType($travelBack);
        }

        $customer->setTravelBackDate($this->getDateOrNull($row[31]));

        $customer->setBoardingPoint($row[32]);

        $customer->setActivityOption($row[33]);

        $customer->setGroupName($row[34]);

        $groupType = $this->getDoctrine()->getRepository(GroupType::class)->findByCode($row[35]);
        if ($groupType)
        {
            $customer->setGroupPreference($groupType);
        }

        $customer->setLodgingLayout($row[36]);


        $group = $this->getDoctrine()->getRepository(Groep::class)->findByGroupIdAndPeriodId($row[37], $customer->getPeriodId());
        if ($group)
        {
            $customer->setGroupLayout($group);
        }

        $customer->setBookerPayed($row[38]);

        $customer->setPayerId($this->getDoctrine()->getRepository(Customer::class)->find($row[39]));

        $customer->setIsCamper($row[40]);

        $customer->setCheckedIn($row[41]);

        $customer->setTotalExclInsurance(is_float($row[42]) ? $row[42] : 0);

        $customer->setInsuranceValue($row[43]);

        return $customer;
    }

    private function importGuide($row): Guide
    {
        $guide = new Guide();

        $guide->setGuideShort($row[0]);
        $guide->setGuideFirstName($row[1]);
        $guide->setGuideLastName($row[2]);

        return $guide;
    }

    private function importGroup($row): Groep
    {
        $group = new Groep();

        $group->setGroupId($row[0]);
        $group->setName($row[1]);
        $group->setPeriodId($row[2]);
        $group->setLocation($row[3]);

        return $group;
    }

    private function importPlanning($row, $periodId): Planning
    {
        $planning = new Planning();

        $planning->setPlanningId($row[0]);

        $planning->setDate($this->convertExcelDateToDateTime($row[1]));

        $group = $this->getDoctrine()->getRepository(Groep::class)->findByGroupIdAndPeriodId($row[2], $periodId);
        if ($group)
        {
            $planning->setGroup($group);
        }

        $planning->setActivity($row[5]);

        $guide = $this->getDoctrine()->getRepository(Guide::class)->findByGuideShort($row[6]);
        if ($guide)
        {
            $planning->setGuide($guide);
        }

        $planning->setGuideFunction($row[7]);

        return $planning;
    }

    private function getDateOrNull($date)
    {
        $date = \DateTime::createFromFormat('d/m/Y', $date);

        return $date ? $date : null;
    }

    private function convertExcelDateToDateTime($dateValue) {

        $unix = ($dateValue - 25569) * 86400;
        $time = new \DateTime();
        $time->setTimestamp($unix);

        return $time;
    }

    private function getDynamicSheetAsArray(Worksheet $sheet) {
        $rows = [];
        foreach ($sheet->getRowIterator() AS $row) {
            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(FALSE); // This loops through all cells,
            $cells = [];
            foreach ($cellIterator as $cell) {
                $code = $cell->getValue();
                if(strstr($code,'=')==true)
                {
                    $code = $cell->getOldCalculatedValue();
                }
                $cells[] = $code;
            }
            $rows[] = $cells;
        }

        return $rows;
    }
}
