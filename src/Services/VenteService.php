<?php


namespace App\Services;


use App\Entity\Point;
use App\Repository\ProduitRepository;
use App\Repository\VenteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMException;

class VenteService
{
    private $em;
    private $venteRepo;
    private $produitRepo;

    public function __construct(EntityManagerInterface $em, VenteRepository $venteRepo, ProduitRepository $produitRepo)
    {
        $this->em = $em;
        $this->venteRepo = $venteRepo;
        $this->produitRepo = $produitRepo;
    }

    /**
     * Sauvegarde la vente et met en base le nombre de point qu'un user a gagné
     * @param $data
     * @param $nbPoint
     */
    public function saveVente($data, $nbPoint)
    {
        $user_id = $data->getUser();
        $produit = $this->produitRepo->find($data->getProduit());
        $point = new Point();
        $nbPointTotal = $nbPoint * $produit->getPoint();
        $point->setNbPoint($nbPointTotal);
        $point->setUser($user_id);
        $point->setDateCreation($data->getDateCreation());

        try {
            $this->em->persist($data);
            $this->em->persist($point);
            $this->em->flush();
        } catch (ORMException $e) {
            echo $e->getMessage();
        }
    }

}