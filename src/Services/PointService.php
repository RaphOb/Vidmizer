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
}