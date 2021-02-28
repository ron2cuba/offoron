<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BandController extends AbstractController
{
    /**
     * @Route("/band", name="band")
     */
    public function index(): Response
    {
        return $this->render('band/index.html.twig', [
            'controller_name' => 'BandController',
        ]);
    }
    /**
     * @Route("/admin/band/create", name="band_create")
     */
    public function createBand(): Response
    {
        return $this->render('admin/create.html.twig', [
            'controller_name' => 'BandController',
        ]);
    }
}
