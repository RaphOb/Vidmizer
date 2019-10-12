<?php


namespace App\Services;


use App\Repository\PointRepository;

class PointService
{
    private $pointRepo;

    public function __construct(PointRepository $pointRepo)
    {
        $this->pointRepo = $pointRepo;
    }

    public function getNbPointByUser($user_id, $start, $end)
    {
        return $this->pointRepo->getPointBetweenDate($user_id, $start, $end);
    }
}