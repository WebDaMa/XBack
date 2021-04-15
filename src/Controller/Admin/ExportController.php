<?php

namespace App\Controller\Admin;

use App\Entity\ExportPeriodAndLocation;
use App\Excell\ExcellExport;
use App\Form\ExportPeriodAndLocationType;
use App\Form\ExportPeriodType;
use App\Repository\GroepRepository;
use App\Repository\LocationRepository;
use App\Utils\Calculations;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/export", name="admin_export_")
 */
class ExportController extends AbstractController {

    /**
     * @Route("/rafting", name="rafting")
     */
    public function raftingAction(Request $request, ExcellExport $excellExport, GroepRepository $groepRepository): Response
    {
        $exportRaft = new ExportPeriodAndLocation();

        $periods = $groepRepository->getAllPeriodIdsAsChoicesForForm();
        if (!empty($periods))
        {
            unset($periods["Alle periodes"]);
            $periods = array_reverse($periods, true);
            $periods["Huidige Periode"] = Calculations::generatePeriodFromDate(date('Y-m-d H:i:s'));
            $periods = array_reverse($periods, true);
        }
        $options = [
            'periods' => $periods
        ];

        $form = $this->createForm(ExportPeriodType::class, $exportRaft, $options);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $periodId = $exportRaft->getPeriod();

            $em = $this->getDoctrine()->getManager();

            $exportRaft->setCreatedBy($this->getUser());
            $em->persist($exportRaft);
            $em->flush();

            $spreadsheet = $excellExport->generateRaftingExportSheet($periodId);

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
     * @Route("/bill", name="bill")
     */
    public function billAction(Request $request, ExcellExport $excellExport, GroepRepository $groepRepository, LocationRepository $locationRepository): Response
    {
        $exportBill = new ExportPeriodAndLocation();

        $locations = $locationRepository->findAllAsChoicesForForm();
        $periods = $groepRepository->getAllPeriodIdsAsChoicesForForm();
        $options = [
            'periods' => $periods,
            'locations' => $locations
        ];

        $form = $this->createForm(ExportPeriodAndLocationType::class, $exportBill, $options);
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

            $spreadsheet = $excellExport->generateBillExportSheet($location, $periodId);

            $writer = IOFactory::createWriter($spreadsheet, "Xlsx");
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment; filename="EindAfrekening-' . $periodId . '-' . $location . '.xlsx"');
            $writer->save("php://output");
            exit();

        }

        return $this->render('dashboard/export.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
