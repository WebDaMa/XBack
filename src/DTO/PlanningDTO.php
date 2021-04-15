<?php


namespace App\DTO;


use App\Entity\Groep;
use App\Entity\Guide;
use App\Entity\Planning;
use App\Repository\GroepRepository;
use App\Repository\GuideRepository;
use App\Utils\Calculations;

class PlanningDTO {

    /**
     * @var GroepRepository
     */
    private $groepRepository;

    /**
     * @var GuideRepository
     */
    private $guideRepository;

    /**
     * PlanningDTO constructor.
     * @param GroepRepository $groepRepository
     * @param GuideRepository $guideRepository
     */
    public function __construct(GroepRepository $groepRepository, GuideRepository $guideRepository)
    {
        $this->groepRepository = $groepRepository;
        $this->guideRepository = $guideRepository;
    }

    public function importPlanning(array $row, $periodId, ?Planning $updatePlanning = null): Planning
    {
        if (is_null($updatePlanning))
        {
            $updatePlanning = new Planning();
        }

        $updatePlanning->setPlanningId((int) $row[0]);

        $updatePlanning->setDate(Calculations::convertExcelDateToDateTime($row[1]));
        $group = $this->groepRepository->findByGroepIdAndPeriodId($row[15], $periodId);
        if ($group)
        {
            $updatePlanning->setGroup($group);
        }

        $updatePlanning->setActivity($row[5]);

        $guide = $this->guideRepository->findByGuideShort($row[6]);
        if ($guide)
        {
            $updatePlanning->setGuide($guide);
        }

        $cag1 = $this->guideRepository->findByGuideShort($row[7]);
        if ($cag1)
        {
            $updatePlanning->setCag1($cag1);
        }

        $cag2 = $this->guideRepository->findByGuideShort($row[8]);
        if ($cag2)
        {
            $updatePlanning->setCag2($cag2);
        }

        $guideFunction = (int) $row[9];
        $updatePlanning->setGuideFunction($guideFunction);

        $updatePlanning->setTransport($row[10]);

        return $updatePlanning;
    }
}