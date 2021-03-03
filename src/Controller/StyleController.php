<?php

namespace App\Controller;

use App\Repository\StyleRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StyleController extends AbstractController
{
    /**
     * @Route("/style", name="style")
     */
    public function index(): Response
    {
        return $this->render('style/index.html.twig', [
            'controller_name' => 'StyleController',
        ]);
    }
    /**
     * @Route("/admin/style/create", name="style_creatStyle")
     */
    public function createStyle(): Response
    {
        return $this->render('admin/create/create-style.html.twig');
    }

    /**
     * @Route("/admin/edit/styles-list", name="style_editStylesList") 
     */
    public function stylesToEdit(StyleRepository $styleRepository): Response
    {
        $page = 'Edit Styles';
        $styles = $styleRepository->findAll();

        return $this->render('admin/edit/styles-list.html.twig', [
            'styles' => $styles,
            'page'=>$page,
        ]);
    }
}
