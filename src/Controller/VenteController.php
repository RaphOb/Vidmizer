<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Entity\User;
use App\Form\ProduitType;
use App\Form\UserType;
use App\Services\ProduitService;
use App\Services\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class VenteController extends AbstractController
{
    private $userService;
    private $produitService;

    public function __construct(UserService $userService, ProduitService $produitService)
    {
        $this->userService = $userService;
        $this->produitService = $produitService;
    }

    /**
     * @Route("/vente", name="vente")
     */
    public function index(Request $request)
    {
        //Creation user
        $user = new User();
        $user_form = $this->createForm(UserType::class, $user);
        $user_form->handleRequest($request);
        if ($user_form->isSubmitted() && $user_form->isValid()) {
            $dataUser = $user_form->getData();
            $this->userService->saveUser($dataUser);
            $this->addFlash('success', 'Un user a ete crée');
            return $this->redirectToRoute('vente');
        }

        //creation de produit
        $produit = new Produit();
        $produit_form = $this->createForm(ProduitType::class, $produit);
        $produit_form->handleRequest($request);
        if ($produit_form->isSubmitted() && $produit_form->isValid()) {
            $dataProduit =  $produit_form->getData();
            $this->produitService->saveProduit($dataProduit);
            $this->addFlash('success', 'Un produit a ete crée');
            return $this->redirectToRoute('vente');
        }

        return $this->render('vente/index.html.twig', [
            'user_form' => $user_form->createView(),
            'produit_form' => $produit_form->createView(),
        ]);
    }
}
