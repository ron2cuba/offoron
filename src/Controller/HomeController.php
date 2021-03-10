<?php

namespace App\Controller;

use Twig\Environment;
use App\Repository\BandRepository;
use App\Repository\StyleRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(Request $request, Environment $twig, BandRepository $bandRepository, StyleRepository $styleRepository):Response
    {
        $styles = $styleRepository->findAll();
        $siteName = "Offoron Records";
        $listArtists = $bandRepository->findAll();

        $html = $twig->render('home/index.html.twig', [
            'siteName'=>$siteName,
            'listAllArtists'=>$listArtists,
            'styles'=>$styles
        ]);

        return new Response($html);
    }
}
