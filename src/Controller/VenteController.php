<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class VenteController extends AbstractController
{
    /**
     * @Route("/vente", name="vente")
     */
    public function index(Request $request)
    {
        $user = new User();
        $user_form = $this->createForm(UserType::class, $user);
        $user_form->handleRequest($request);
        if ($user_form->isSubmitted() && $user_form->isValid()) {
            $user = $user_form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash('success', 'Un user a ete crée');
            return $this->redirectToRoute('vente');
        }

        return $this->render('vente/index.html.twig', [
            'user_form' => $user_form->createView(),
        ]);
    }
}
