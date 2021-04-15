<?php

namespace App\Controller\Admin;

use App\Entity\ExportPeriodAndLocation;
use App\Excel\ExcelExport;
use App\Form\ExportPeriodAndLocationType;
use App\Form\ExportPeriodType;
use App\Form\ExportYearType;
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
     * @Route("/rafting-period", name="rafting_period")
     */
    public function raftingPeriodAction(Request $request, ExcelExport $excellExport, GroepRepository $groepRepository): Response
    {
        $exportRaft = new ExportPeriodAndLocation();

        $periods = $groepRepository->getAllPeriodIdsAsChoicesForForm();
        if (!empty($periods))
        {
            unset($periods["All periods"]);
            $periods = array_reverse($periods, true);
            $periods["Current period"] = Calculations::generatePeriodFromDate(date('Y-m-d H:i:s'));
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

            $fileName = 'raftingCustomers-' . $periodId . '.xlsx';
            $exportRaft->setCreatedBy($this->getUser());
            $exportRaft->setFileName($fileName);
            $em->persist($exportRaft);
            $em->flush();

            $spreadsheet = $excellExport->generateRaftingExportSheetForPeriod($periodId);

            $writer = IOFactory::createWriter($spreadsheet, "Xlsx");
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment; filename="' . $fileName . '"');
            $writer->save("php://output");
            exit();

        }

        return $this->render('dashboard/export.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/rafting-year", name="rafting_year")
     */
    public function raftingYearAction(Request $request, ExcelExport $excellExport, GroepRepository $groepRepository): Response
    {
        $exportRaft = new ExportPeriodAndLocation();

        $years = $groepRepository->getAllYearsAsChoicesForForm();
        if (!empty($years))
        {
            unset($years["All years"]);
            $years = array_reverse($years, true);
            $years["Current year"] = substr(date('Y'), 2, 2);
            $years = array_reverse($years, true);
        }
        $options = [
            'years' => $years
        ];

        $form = $this->createForm(ExportYearType::class, $exportRaft, $options);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $year = $exportRaft->getPeriod();

            $em = $this->getDoctrine()->getManager();

            $fileName = 'raftingCustomers-' . $year . '.xlsx';
            $exportRaft->setCreatedBy($this->getUser());
            $exportRaft->setFileName($fileName);
            $em->persist($exportRaft);
            $em->flush();

            $spreadsheet = $excellExport->generateRaftingExportSheetForYear($year);

            $writer = IOFactory::createWriter($spreadsheet, "Xlsx");
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment; filename="' . $fileName . '"');
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
    public function billAction(Request $request, ExcelExport $excellExport, GroepRepository $groepRepository, LocationRepository $locationRepository): Response
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
