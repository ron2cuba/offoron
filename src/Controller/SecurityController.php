<?php

namespace App\Controller;

use App\Form\LoginType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="security_login", priority=4)
     */
    public function login(AuthenticationUtils $utils): Response
    {
        $form = $this->createForm(LoginType::class, ['username' => $utils->getLastUsername()]);

        return $this->render('security/login.html.twig', [
            'formView'=> $form->createView(),
            'error'=> $utils->getLastAuthenticationError()
        ]);
    }
    /**
     * @Route("/logout", name="security_logout")
     */
    public function logout()
    {

    }
}
