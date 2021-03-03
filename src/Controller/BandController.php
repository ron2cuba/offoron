<?php

namespace App\Controller;

use App\Entity\Band;
use App\Entity\Style;
use App\Form\BandType;
use App\Repository\BandRepository;
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
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
     * @Route("/admin/{id}/edit", name="band_editBand")
     */
    public function editBand($id, BandRepository $bandRepository, Request $request, EntityManagerInterface $em, SluggerInterface $slugger) : Response  
    {
        $band = $bandRepository->find($id);

        $form = $this->createForm(BandType::class, $band);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            
            $band->setSlug($slugger->slug($band->getName()));

            $em->flush();
        }


        $formView = $form->createView();

        return $this->render('admin/edit-band.html.twig',[
            'band'=>$band,
            'formView'=>$formView
        ]);
    }

    /**
     * @Route("/admin/band/create", name="band_create")
     */
    public function createBand(StyleRepository $styleRepository, Request $request, SluggerInterface $slugger, EntityManagerInterface $em): Response
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

        $formView = $form->createView();

        return $this->render('admin/create/create-band.html.twig', [
            'formView'=>$formView
        ]);
    }

    /**
     * @Route("/{slug}", name="band_details")
     */
    public function viewBand($slug, BandRepository $bandRepository)
    {
        $details = $bandRepository->findOneBy([
            'slug'=>$slug
        ]);

        return $this->render('band/view.html.twig', [
            'details'=>$details
        ]);
    }

}
