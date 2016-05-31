<?php
// src/BlogBundle/Controller/RegistrationController.php
namespace BlogBundle\Controller;

use BlogBundle\Form\UserType;
use BlogBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RegistrationController extends Controller
{
    #/**
    #* @Route("/register", name="user_registration")
    #*/
    public function registerAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user, array(
            'method' => 'POST') );

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() ) {

            $password = $this->get('security.password_encoder')
                    ->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('blog_home');
        }

        return $this->render(
            'BlogBundle:Page:register.html.twig',
            array(
                'form' => $form->createView(),
                'username' => ''
            )
        );
    }
}