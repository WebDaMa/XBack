<?php


namespace App\DTO;


use App\Entity\Guide;

class GuideDTO {

    public function importGuide(array $row): Guide
    {
        $guide = new Guide();

        $guide->setGuideShort($row[0]);
        $guide->setGuideFirstName(trim($row[1]));
        $guide->setGuideLastName(trim($row[2]));

        return $guide;
    }
}