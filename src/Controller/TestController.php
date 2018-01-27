<?php

namespace App\Controller;

use App\Entity\Agency;
use App\Entity\AllInType;
use App\Entity\BOUpload;
use App\Entity\Customer;
use App\Entity\GroupType;
use App\Entity\InsuranceType;
use App\Entity\Location;
use App\Entity\LodgingType;
use App\Entity\ProgramType;
use App\Entity\TravelType;
use App\Form\BOUploadType;
use App\Repository\AgencyRepository;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TestController extends Controller
{
    /**
     * @Route("admin/test", name="test")
     */
    public function index(Request $request)
    {
        $boUpload = new BOUpload();
        $form = $this->createForm(BOUploadType::class, $boUpload);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $file stores the uploaded PDF file
            /** @var UploadedFile $file */
            $file = $boUpload->getBoPeriodFile();

            $rp = $file->getRealPath();

            $spreadsheet = IOFactory::load($rp);
            $sheet = $spreadsheet->getActiveSheet()->toArray();

            //Remove headers
            array_shift($sheet);

            if(is_array($sheet)) {
                //Mapping
                $em = $this->getDoctrine()->getManager();
                foreach ($sheet as $row) {
                    $customer = $this->importCustomer($row);

                    $em->persist($customer);
                }
                $boUpload->setBoPeriodFile($file->getClientOriginalName());

                $em->persist($boUpload);

                $em->flush();
            }


            return $this->redirect($this->generateUrl('admin'));
        }

        return $this->render('dashboard/index.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    private function importCustomer($row) {
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
        $customer->setSize($row[13]);
        $customer->setNameShortage($row[14]);
        $customer->setEmergencyNumber($row[15]);
        $customer->setLicensePlate($row[16]);

        $customer->setTypePerson($row[17]);

        $customer->setInfoCustomer($row[18]);
        $customer->setInfoFile($row[19]);

        $agency = $this->getDoctrine()->getRepository(Agency::class)->findByCode($row[20]);
        if($agency) {
            $customer->setAgency($agency);
        }

        $location = $this->getDoctrine()->getRepository(Location::class)->findByCode($row[21]);
        if($location) {
            $customer->setLocation($location);
        }

        $customer->setStartDay($this->getDateOrNull($row[22]));
        $customer->setEndDay($this->getDateOrNull($row[23]));

        $program = $this->getDoctrine()->getRepository(ProgramType::class)->findByCode($row[24]);
        if($program) {
            $customer->setProgramType($program);
        }

        $lodging = $this->getDoctrine()->getRepository(LodgingType::class)->findByCode($row[25]);
        if($lodging) {
            $customer->setLodgingType($lodging);
        }

        $allIn = $this->getDoctrine()->getRepository(AllInType::class)->findByCode($row[26]);
        if($allIn) {
            $customer->setAllInType($allIn);
        }

        $insuranceType = $this->getDoctrine()->getRepository(InsuranceType::class)->findByCode($row[27]);
        if($insuranceType) {
            $customer->setInsuranceType($insuranceType);
        }

        $travelGo = $this->getDoctrine()->getRepository(TravelType::class)->findByCode($row[28]);
        if($travelGo) {
            $customer->setTravelGoType($travelGo);
        }

        $customer->setTravelGoDate($this->getDateOrNull($row[29]));

        $travelBack = $this->getDoctrine()->getRepository(TravelType::class)->findByCode($row[30]);
        if($travelBack) {
            $customer->setTravelBackType($travelBack);
        }

        $customer->setTravelBackDate($this->getDateOrNull($row[31]));

        $customer->setBoardingPoint($row[32]);

        $customer->setActivityOption($row[33]);

        $customer->setGroupName($row[34]);

        $groupType = $this->getDoctrine()->getRepository(GroupType::class)->findByCode($row[35]);
        if($groupType) {
            $customer->setGroupPreference($groupType);
        }

        $customer->setLodgingLayout($row[36]);

        $customer->setGroupLayout($row[37]);

        $customer->setBookerPayed($row[38]);

        $customer->setPayerId($this->getDoctrine()->getRepository(Customer::class)->find($row[39]));

        $customer->setIsCamper($row[40]);

        $customer->setCheckedIn($row[41]);

        $customer->setTotalExclInsurance(is_float($row[42]) ? $row[42] : 0);

        $customer->setInsuranceValue($row[43]);

        return $customer;
    }

    private function getDateOrNull($date) {
        $date = \DateTime::createFromFormat('d/m/Y', $date);
        return $date ? $date : null;
    }
}
