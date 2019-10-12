<?php


namespace App\Services;


use App\Repository\PointRepository;
use Doctrine\ORM\EntityManagerInterface;

class ProduitService
{
    private $em;
    private $produitRepo;

    public function __construct(PointRepository $produitRepo, EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->produitRepo = $produitRepo;
    }

    public function saveProduit($data)
    {
        $this->em->persist($data);
        $this->em->flush();
    }

}