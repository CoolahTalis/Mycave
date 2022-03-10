<?php

namespace App\Controller;

use App\Entity\Vin;
use App\Form\VinType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminVinController extends AbstractController
{
    /**
     * @Route("/ajout", name="ajout", methods={"GET","POST"})
     */
    public function addVin(Request $request): Response
    {
        $vin = new Vin();
        $form = $this->createForm(VinType::class, $vin);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($vin);
            $entityManager->flush();

            return $this->redirectToRoute('listVins');
        }

        return $this->render('admin_vin/ajout.html.twig', [
            'vin' => $vin,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/{id}/modif", name="modif", methods={"GET","POST"})
     */
    public function modif(Request $request, Vin $vin): Response
    {
        $form = $this->createForm(VinType::class, $vin);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('listVins');
        }

        return $this->render('admin_vin/modif.html.twig', [
            'vin' => $vin,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="supprimer", methods={"SUPPRIMER"})
     */
    public function suppression(Request $request, Vin $vin): Response
    {
        if ($this->isCsrfTokenValid('supprimer'.$vin->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($vin);
            $entityManager->flush();
        }

        return $this->redirectToRoute('listVins');
    }

}
