<?php

namespace App\Controller;

use App\Entity\Activity;
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

                    $customerExists = $this->getDoctrine()->getRepository(Customer::class)->findByCustomerId($customer->getCustomerId());

                    if(!is_null($customerExists) || $customerExists) {
                        //Update current
                        $customer = $this->importCustomer($row, $customerExists);
                    }

                    $em->persist($customer);
                }
                $upload->setFile($file->getClientOriginalName());

                $em->persist($upload);

                $em->flush();

                $this->addFlash(
                    'notice',
                    'Your Customers were saved!'
                );
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

                    $guideExists = $this->getDoctrine()->getRepository(Guide::class)->findByGuideShort($guide->getGuideShort());

                    if(is_null($guideExists) || !$guideExists) {
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
                    $groep = $this->importGroep($row);
                    $periodId = $groep->getPeriodId();

                    $groepExists = $this->getDoctrine()->getRepository(Groep::class)->findByGroupIdAndPeriodId($groep->getGroupId(), $periodId);

                    if(!is_null($groepExists) || $groepExists) {
                        //Update current
                        $groep = $this->importGroep($row, $groepExists);
                    }

                    if(!is_null($groep->getName()) && !empty($groep->getName()) && $groep->getName() !== '') {
                        //Don't add empty groeps
                        $em->persist($groep);
                    }

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

                    $planningExists = $this->getDoctrine()->getRepository(Planning::class)->findByPlanningIdAndDate($planning->getPlanningId(), $planning->getDate());

                    if(!is_null($planningExists) || $planningExists) {
                        //Update current
                        $planning = $this->importPlanning($row, $periodId, $planningExists);
                    }

                    $em->persist($planning);
                }
            }

            $upload->setFile($file->getClientOriginalName());

            $em->persist($upload);

            $em->flush();

            $this->addFlash(
                'notice',
                'Your plannings were saved!'
            );

            return $this->redirect($this->generateUrl('admin', array('entity' => 'Planning')));
        }

        return $this->render('dashboard/import.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    private function importCustomer($row, ?Customer $updateCustomer = null): Customer
    {
        if(is_null($updateCustomer)) {
            $updateCustomer = new Customer();
        }

        $updateCustomer->setCustomerId($row[0]);
        $updateCustomer->setFileId($row[1]);
        $updateCustomer->setPeriodId($row[3]);
        $updateCustomer->setBookerId($row[4]);
        $updateCustomer->setBooker($row[5]);
        $updateCustomer->setLastName($row[6]);
        $updateCustomer->setFirstName($row[7]);
        $updateCustomer->setBirthdate($this->getDateOrNull($row[8]));
        $updateCustomer->setEmail($row[9]);
        $updateCustomer->setGsm($row[10]);
        $updateCustomer->setNationalRegisterNumber($row[11]);
        $updateCustomer->setExpireDate($this->getDateOrNull($row[12]));

        $size = $this->getDoctrine()->getRepository(SuitSize::class)->findByName($row[13]);
        if ($size)
        {
            $updateCustomer->setSize($size);
        }

        $updateCustomer->setNameShortage($row[14]);
        $updateCustomer->setEmergencyNumber($row[15]);
        $updateCustomer->setLicensePlate($row[16]);

        $updateCustomer->setTypePerson($row[17]);

        $updateCustomer->setInfoCustomer($row[18]);
        $updateCustomer->setInfoFile($row[19]);

        $agency = $this->getDoctrine()->getRepository(Agency::class)->findByCode($row[20]);
        if ($agency)
        {
            $updateCustomer->setAgency($agency);
        }

        $location = $this->getDoctrine()->getRepository(Location::class)->findByCode($row[21]);
        if ($location)
        {
            $updateCustomer->setLocation($location);
        }

        $updateCustomer->setStartDay($this->getDateOrNull($row[22]));
        $updateCustomer->setEndDay($this->getDateOrNull($row[23]));

        $program = $this->getDoctrine()->getRepository(ProgramType::class)->findByCode($row[24]);
        if ($program)
        {
            $updateCustomer->setProgramType($program);
        }

        $lodging = $this->getDoctrine()->getRepository(LodgingType::class)->findByCode($row[25]);
        if ($lodging)
        {
            $updateCustomer->setLodgingType($lodging);
        }

        $allIn = $this->getDoctrine()->getRepository(AllInType::class)->findByCode($row[26]);
        if ($allIn)
        {
            $updateCustomer->setAllInType($allIn);
        }

        $insuranceType = $this->getDoctrine()->getRepository(InsuranceType::class)->findByCode($row[27]);
        if ($insuranceType)
        {
            $updateCustomer->setInsuranceType($insuranceType);
        }

        $travelGo = $this->getDoctrine()->getRepository(TravelType::class)->findByCode($row[28]);
        if ($travelGo)
        {
            $updateCustomer->setTravelGoType($travelGo);
        }

        $updateCustomer->setTravelGoDate($this->getDateOrNull($row[29]));

        $travelBack = $this->getDoctrine()->getRepository(TravelType::class)->findByCode($row[30]);
        if ($travelBack)
        {
            $updateCustomer->setTravelBackType($travelBack);
        }

        $updateCustomer->setTravelBackDate($this->getDateOrNull($row[31]));

        $updateCustomer->setBoardingPoint($row[32]);

        $updateCustomer->setActivityOption($row[33]);

        $updateCustomer->setGroupName($row[34]);

        $groupType = $this->getDoctrine()->getRepository(GroupType::class)->findByCode($row[35]);
        if ($groupType)
        {
            $updateCustomer->setGroupPreference($groupType);
        }

        $updateCustomer->setLodgingLayout($row[36]);


        $group = $this->getDoctrine()->getRepository(Groep::class)->findByGroupIdAndPeriodId($row[37], $updateCustomer->getPeriodId());
        if ($group)
        {
            $updateCustomer->setGroupLayout($group);
        }

        $updateCustomer->setBookerPayed($row[38]);

        $updateCustomer->setPayerId($this->getDoctrine()->getRepository(Customer::class)->find($row[39]));

        $updateCustomer->setIsCamper($row[40]);

        $updateCustomer->setCheckedIn($row[41]);

        $updateCustomer->setTotalExclInsurance(is_float($row[42]) ? $row[42] : 0);

        $updateCustomer->setInsuranceValue($row[43]);

        return $updateCustomer;
    }

    private function importGuide($row): Guide
    {
        $guide = new Guide();

        $guide->setGuideShort($row[0]);
        $guide->setGuideFirstName($row[1]);
        $guide->setGuideLastName($row[2]);

        return $guide;
    }

    private function importGroep($row, ?Groep $updateGroep = null): Groep
    {
        if(is_null($updateGroep)) {
            $updateGroep = new Groep();
        }

        $updateGroep->setGroupId($row[0]);
        $updateGroep->setName($row[1]);
        $updateGroep->setPeriodId($row[2]);
        $updateGroep->setLocation($row[3]);

        return $updateGroep;
    }

    private function importPlanning($row, $periodId, ?Planning $updatePlanning = null): Planning
    {
        if(is_null($updatePlanning)) {
            $updatePlanning = new Planning();
        }

        $updatePlanning->setPlanningId($row[0]);

        $updatePlanning->setDate($this->convertExcelDateToDateTime($row[1]));

        $group = $this->getDoctrine()->getRepository(Groep::class)->findByGroupIdAndPeriodId($row[2], $periodId);
        if ($group)
        {
            $updatePlanning->setGroup($group);
        }

        $activity = $this->getDoctrine()->getRepository(Activity::class)->findByName($row[5]);
        if ($activity)
        {
            $updatePlanning->setActivity($activity);
        }

        $guide = $this->getDoctrine()->getRepository(Guide::class)->findByGuideShort($row[6]);
        if ($guide)
        {
            $updatePlanning->setGuide($guide);
        }

        $updatePlanning->setGuideFunction($row[7]);

        return $updatePlanning;
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
