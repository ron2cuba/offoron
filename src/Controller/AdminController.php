<?php

namespace App\Controller;

use App\Form\BandType;
use App\Form\StyleType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{
    /**
     * injection du formulaire de creation de groupe dans le template
     * @Route("/admin", name="admin", priority=3)
     */
    public function createBand(Request $request, SluggerInterface $slugger, EntityManagerInterface $em): Response
    {
        // le form que l'on créer doit travailler sur la classe Band avec une class FomrType
        $form = $this->createForm(BandType::class);

        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){

            $band = $form->getData();
            $band->setSlug(\strtolower($slugger->slug($band->getName())));
            $em->persist($band);
            $em->flush();
        }

        $formCreateBand = $form->createView();
        $pageName = "admin";

        return $this->render('admin/index.html.twig', [
            'formCreateBand'=>$formCreateBand,
            'pageName'=>$pageName
        ]);
    }

    
}
