<?php

namespace App\Controller;

use App\Entity\Band;
use App\Entity\Style;
use App\Form\BandType;
use App\Repository\BandRepository;
use App\Controller\StyleController;
use App\Repository\StyleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BandController extends AbstractController
{
    /**
     *  Display page Details for one band
     *  @Route("/{slug}", name="band_show")
     */
    public function show($slug, BandRepository $bandRepository)
    {
        $band = $bandRepository->findOneBy([
            'slug' => $slug
            ]);
        
            if(!$band){
                throw $this->createNotFoundException('L\'artiste demandé n\'existe pas');                
            }

            return $this->render('band/view.html.twig', [
                'band'=>$band
            ]);
    }

    /**
     * Display the list of bands that can be edited
     * @Route("/admin/edit/bands-list", name="band_editBandsList") 
     */
    public function bandsToEdit(BandRepository $bandRepository): Response
    {
        $bands = $bandRepository->findAll();

        return $this->render('admin/edit/bands-list.html.twig', [
            'bands' => $bands,
        ]);
    }

    /**
     * Display edtion page for a band
     * @Route("/admin/{id}/edit", name="band_editBand")
     */
    public function editBand($id, BandRepository $bandRepository, Request $request, EntityManagerInterface $em, SluggerInterface $slugger, UrlGeneratorInterface $urlGenerator) : Response  
    {
        $band = $bandRepository->find($id);

        $form = $this->createForm(BandType::class, $band);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            
            $band->setSlug($slugger->slug($band->getName()));

            $em->flush();

            return $this->redirectToRoute('band_show', [
                'slug'=>$band->getSlug()
                ]);

        }


        $formView = $form->createView();

        return $this->render('admin/edit/edit-band.html.twig',[
            'band'=>$band,
            'formView'=>$formView
        ]);
    }

    /**
     * Display creation page for band
     * @Route("/admin/band/create", name="band_create")
     */
    public function createBand(StyleRepository $styleRepository, Request $request, SluggerInterface $slugger, EntityManagerInterface $em): Response
    {
        $pageName = 'Création d\'un groupe || Artiste';
        // le form que l'on créer doit travailler sur la classe Band avec une class FomrType
        $form = $this->createForm(BandType::class);

        $form->handleRequest($request);

        
        if($form->isSubmitted() && $form->isValid()){

            $band = $form->getData();
            $band->setSlug(\strtolower($slugger->slug($band->getName())));
            $em->persist($band);
            $em->flush();

            return $this->redirectToRoute('band_show', [
                'slug'=>$band->getSlug()
            ]);
        }

        $formView = $form->createView();

        return $this->render('admin/create/create-band.html.twig', [
            'pageName ' => $pageName,
            'formCreateBand'=>$formView
        ]);
    }

    /**
     * Display page details for a band
     * @Route("/{slug}", name="band_details")
     */
    public function viewBand($slug, BandRepository $bandRepository)
    {
        /**
         * redirect if slug === styles
         */
        if($slug === "styles" ){
            
            $response = $this->forward('App\Controller\StyleController::view', []);

            return $response;
        }

        $details = $bandRepository->findOneBy([
            'slug'=>$slug
        ]);

        return $this->render('band/view.html.twig', [
            'details'=>$details
        ]);
    }

}
