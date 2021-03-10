<?php

namespace App\Controller;

use App\Form\StyleType;
use App\Repository\BandRepository;
use App\Repository\StyleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StyleController extends AbstractController
{
    /**
     * Display all Styles in Db
     * @Route("/styles", name="style")
     */
    public function view(StyleRepository $styleRepository): Response
    {
        echo('yeah');
        /* $styles =$styleRepository->findAll();
        return $this->render('styles-list/view.html.twig', [
            'styles' => $styles,
        ]); */
    }
    /**
     * Display style page edition
     * @Route("admin/edit/style/{id}", name="style_editStyle")
     */
    public function editStyle($id, StyleRepository $styleRepository, Request $request, EntityManagerInterface $em, SluggerInterface $slugger)
    {
        $style = $styleRepository->find($id);

        $form = $this->createForm(StyleType::class, $style);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $em->flush();
        }

        $formView = $form->createView();

        return $this->render('admin/edit/edit-style.html.twig', [
            'style'=>$style,
            'formView'=>$formView

        ]);
    }
    /**
     * Display style page creation
     * @Route("/admin/style/create", name="style_creatStyle")
     */
    public function createStyle(Request $request, StyleRepository $styleRepository, SluggerInterface $slugger, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(StyleType::class);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $band = $form->getData();
            // $style->setSlug(\strtolower($slugger->slug($style->getName())));
            $em->persist($band);
            $em->flush();
        }

        $formView = $form->createView();

        return $this->render('admin/create/create-style.html.twig', [
            'formView'=>$formView
        ]);
    }

    /**
     * Display the list of bands that can be edited
     * @Route("/admin/edit/styles-list", name="style_editStylesList") 
     */
    public function stylesToEdit(StyleRepository $styleRepository): Response
    {
        $styles = $styleRepository->findAll();
        $page = "Edition des styles :";

        return $this->render('admin/edit/styles-list.html.twig', [
            'styles' => $styles,
            'page'=> $page,
        ]);
    }


}
