<?php

namespace App\Controller\Admin;

use App\Entity\ExportPeriodAndLocation;
use App\Excel\ExcelExport;
use App\Form\ExportPeriodAndLocationType;
use App\Form\ExportPeriodType;
use App\Form\ExportYearAndLocationType;
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
        $periods = $this->replaceAllPeriodsWithCurrentPeriod($periods);
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
        $years = $this->replaceAllYearsWithCurrentYear($years);
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
     * @Route("/bill-period", name="bill_period")
     */
    public function billPeriodAction(Request $request, ExcelExport $excellExport, GroepRepository $groepRepository, LocationRepository $locationRepository): Response
    {
        $exportBill = new ExportPeriodAndLocation();

        $locations = $locationRepository->findAllAsChoicesForForm();
        $periods = $groepRepository->getAllPeriodIdsAsChoicesForForm();
        $periods = $this->replaceAllPeriodsWithCurrentPeriod($periods);
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
            $fileName = 'EindAfrekening-' . $periodId . '-' . $location . '.xlsx';

            $em = $this->getDoctrine()->getManager();

            $exportBill->setCreatedBy($this->getUser());
            $exportBill->setFileName($fileName);
            $em->persist($exportBill);
            $em->flush();

            $spreadsheet = $excellExport->generateBillExportSheetForPeriodAndLocation($periodId, $location);

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
     * @Route("/bill-year", name="bill_year")
     */
    public function billYearAction(Request $request, ExcelExport $excellExport, GroepRepository $groepRepository, LocationRepository $locationRepository): Response
    {
        $exportBill = new ExportPeriodAndLocation();

        $locations = $locationRepository->findAllAsChoicesForForm();
        $years = $groepRepository->getAllYearsAsChoicesForForm();
        $years = $this->replaceAllYearsWithCurrentYear($years);
        $options = [
            'years' => $years,
            'locations' => $locations
        ];

        $form = $this->createForm(ExportYearAndLocationType::class, $exportBill, $options);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            // $file stores the uploaded file
            /** @var UploadedFile $file */
            $location = $exportBill->getLocation();
            $year = $exportBill->getPeriod();
            $fileName = 'EindAfrekening-' . $year . '-' . $location . '.xlsx';

            $em = $this->getDoctrine()->getManager();

            $exportBill->setCreatedBy($this->getUser());
            $exportBill->setFileName($fileName);
            $em->persist($exportBill);
            $em->flush();

            $spreadsheet = $excellExport->generateBillExportSheetForYearAndLocation($year, $location);

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
     * @param array $years
     * @return array
     */
    private function replaceAllYearsWithCurrentYear(array $years): array
    {
        if (!empty($years))
        {
            unset($years["All years"]);
            $years = array_reverse($years, true);
            $years["Current year"] = substr(date('Y'), 2, 2);
            $years = array_reverse($years, true);
        }
        return $years;
    }

    /**
     * @param array $periods
     * @return array
     */
    private function replaceAllPeriodsWithCurrentPeriod(array $periods): array
    {
        if (!empty($periods))
        {
            unset($periods["All periods"]);
            $periods = array_reverse($periods, true);
            $periods["Current period"] = Calculations::generatePeriodFromDate(date('Y-m-d H:i:s'));
            $periods = array_reverse($periods, true);
        }
        return $periods;
    }
}
