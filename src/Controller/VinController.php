<?php

namespace App\Controller;

use App\Entity\Vin;
use App\Repository\VinRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VinController extends AbstractController
{
    /**
     * @Route("/", name="accueil")
     */
    public function index(): Response
    {
        return $this->render('vin/accueil.html.twig');
    }

    /**
     * @Route("/listVins", name="listVins")
     */
    public function displayAll(VinRepository $vinRepository): Response
    {
        return $this->render('vin/listVins.html.twig', [
            'vins' => $vinRepository->findAll(),
            'isYear' => true
        ]);
    }

    /**
     * @Route("/listVins/{year}", name="filtreYear")
     *
     * @return response
     */
    public function filtrePerYear(VinRepository $vinRepository, $year): response
    {
        $vins = $vinRepository->getVinPerYears($year);
        return $this->render('vin/listVins.html.twig', [
            'vins' => $vins,
            'isYear' => true
        ]);
    }

    /**
     * @Route("/{id}", name="vin")
     */
    public function displayOne(Vin $vin): Response
    {
        return $this->render('vin/vin.html.twig', [
            'vin' => $vin
        ]);
    }


}
