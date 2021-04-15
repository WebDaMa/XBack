<?php

namespace App\Controller\Admin;

use App\DTO\CustomerDTO;
use App\DTO\GroepDTO;
use App\DTO\GuideDTO;
use App\DTO\PlanningDTO;
use App\Entity\Upload;
use App\Entity\Customer;
use App\Form\UploadType;
use App\Repository\GroepRepository;
use App\Repository\GuideRepository;
use App\Repository\PlanningRepository;
use App\Utils\Extensions;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/import", name="admin_import_")
 */
class ImportController extends AbstractController {

    /**
     * @Route("/bo", name="bo")
     */
    public function boAction(Request $request, AdminUrlGenerator $adminUrlGenerator, CustomerDTO $customerDTO)
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
                        $customer = $customerDTO->importCustomer($row);

                        if (!is_null($customer->getCustomerId()) && !is_null($customer->getPeriodId()))
                        {
                            $customerExists = $this->getDoctrine()->getRepository(Customer::class)->findByCustomerId($customer->getCustomerId());

                            if (!is_null($customerExists) || $customerExists)
                            {
                                //Update current
                                $customerDTO->importCustomer($row, $customerExists);
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
            // redirect to some CRUD controller
            return $this->redirect($adminUrlGenerator->setController(CustomerCrudController::class)->generateUrl());
        }

        return $this->render('dashboard/import.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/planning", name="planning")
     */
    public function planningAction(Request $request, AdminUrlGenerator $adminUrlGenerator, GuideDTO $guideDTO, GroepDTO $groepDTO, PlanningDTO $planningDTO, GuideRepository $guideRepository, GroepRepository $groepRepository, PlanningRepository $planningRepository)
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
                    $guide = $guideDTO->importGuide($row);

                    $guideExists = $guideRepository->findByGuideShort($guide->getGuideShort());

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
                    $groep = $groepDTO->importGroep($row);

                    if (!is_null($groep->getPeriodId()) && !is_null($groep->getLocation()))
                    {
                        $periodId = $groep->getPeriodId();
                        $location = $groep->getLocation();

                        $groepExists = null;

                        if (!is_null($location))
                        {
                            $groepExists = $groepRepository->findByGroepIdAndPeriodIdAndLocationId($groep->getGroupId(), $periodId, $location->getId());
                        }

                        if (!is_null($groepExists) || $groepExists)
                        {
                            //Update current
                            $groep = $groepDTO->importGroep($row, $groepExists);
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
                    $planning = $planningDTO->importPlanning($row, $periodId);
                    if (!is_null($planning->getPlanningId()) && !is_null($planning->getDate()))
                    {

                        $planningExists = $planningRepository
                            ->findByPlanningIdAndDateAndGroepId($planning->getPlanningId(), $planning->getDate(), $row[15]);

                        if (!is_null($planningExists) || $planningExists)
                        {
                            //Update current
                            $planning = $planningDTO->importPlanning($row, $periodId, $planningRepository->find($planningExists));
                        }

                        if (!is_null($planning->getActivity()) && !empty($planning->getActivity()))
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

            // redirect to some CRUD controller
            return $this->redirect($adminUrlGenerator->setController(PlanningCrudController::class)->generateUrl());
        }

        return $this->render('dashboard/import.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
