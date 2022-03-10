<?php

namespace App\Controller;

use App\Entity\Domaine;
use App\Form\DomaineType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminDomaineController extends AbstractController
{
    /**
     * @Route("/ajout_dom", name="ajout_dom", methods={"GET","POST"})
     */
    public function addVinDom(Request $request): Response
    {
        $dom = new Domaine();
        $forms = $this->createForm(DomaineType::class, $dom);
        $forms->handleRequest($request);

        if ($forms->isSubmitted() && $forms->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($dom);
            $entityManager->flush();

            return $this->redirectToRoute('ajout');
        }

        return $this->render('admin_domaine/ajout_dom.html.twig', [
            'dom' => $dom,
            'forms' => $forms->createView(),
        ]);
    }
}
