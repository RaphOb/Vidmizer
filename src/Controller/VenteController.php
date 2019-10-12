<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Entity\User;
use App\Entity\Vente;
use App\Form\ProduitType;
use App\Form\SearchPointType;
use App\Form\UserType;
use App\Form\VenteType;
use App\Services\PointService;
use App\Services\ProduitService;
use App\Services\UserService;
use App\Services\VenteService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class VenteController extends AbstractController
{
    private $userService;
    private $produitService;
    private $venteService;
    private $pointService;

    public function __construct(UserService $userService, ProduitService $produitService, VenteService $venteService, PointService $pointService)
    {
        $this->userService = $userService;
        $this->produitService = $produitService;
        $this->venteService = $venteService;
        $this->pointService = $pointService;
    }

    /**
     * @Route("/vente", name="vente")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
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
            $dataProduit = $produit_form->getData();
            $this->produitService->saveProduit($dataProduit);
            $this->addFlash('success', 'Un produit a ete crée');
            return $this->redirectToRoute('vente');
        }

        //creation de la vente
        $vente = new Vente();
        $vente_form = $this->createForm(VenteType::class, $vente);
        $vente_form->handleRequest($request);
        if ($vente_form->isSubmitted() && $vente_form->isValid()) {
            $data = $vente_form->getData();
            $this->venteService->saveVente($data, $vente_form['quantity']->getData());
            $this->addFlash('success', 'Une vente a ete réalisée');
            return $this->redirectToRoute('vente');
        }

        //Formulaire pour chercher les nombres de points par utilisateur et par data
        $search_form = $this->createForm(SearchPointType::class);
        $search_form->handleRequest($request);
        if ($search_form->isSubmitted() && $search_form->isValid()) {
            $start = $search_form['dateStart']->getData();
            $end = $search_form['dateEnd']->getData();
            $user_id = $search_form['user']->getData();
            $user = $this->userService->getUserById($user_id);
            $data = $this->pointService->getNbPointByUser($user_id, $start, $end);
            if(!$data) {
                $data = 0;
            }

            return $this->render('vente/test.html.twig', [
                'data' => $data,
                'username' => $user->getName()
            ]);
        }

        return $this->render('vente/index.html.twig', [
            'user_form' => $user_form->createView(),
            'produit_form' => $produit_form->createView(),
            'vente_form' => $vente_form->createView(),
            'search_form' => $search_form->createView()
        ]);
    }
}
