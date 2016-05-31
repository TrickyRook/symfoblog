<?php
// src/BlogBundle/Controller/PageController.php

namespace BlogBundle\Controller;

use BlogBundle\Entity\BlogPost;
use BlogBundle\Entity\User;
use BlogBundle\Form\PostType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
#use BlogBundle\Entity\Enquiry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
#use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;


class PageController extends Controller
{

    public function getLoggedName() {
        if (!$this->getUser())
            return 'You\'re not logged';
        else
            return 'You\'re logged as ' . $this->getUser()->getUserName();
    }

    public function getUserNameById($Id) {
        $query = $this->getDoctrine()
            ->getRepository('BlogBundle:User')
            ->findBy(array('id' => $Id));
        return $query[0]->getUserName();
    }

    public function indexAction($slug)
    {
        $posts = $this->getDoctrine()
            ->getRepository('BlogBundle:BlogPost')
            ->findBy(array(), array('id' => 'DESC'), 10, ($slug-1)*10);

        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery('SELECT count(p) FROM BlogBundle:BlogPost p');
        $pages = ceil( $query->getSingleScalarResult() / 10 );

        foreach ($posts as $post ) {
            $post->setAuthor($this->getUserNameById($post->getAuth()));
        }
        #var_dump($posts);

        return $this->render('BlogBundle:Page:index.html.twig',
            array(
                'posts'    => $posts,
                'pages'    => $pages,
                'curpage'  => $slug,
                'username' => $this->getLoggedName(),
            )
        );
    }

    public function showAction($slug)
    {
        $post = $this->getDoctrine()
            ->getRepository('BlogBundle:BlogPost')
            ->find($slug);

        $author = $this->getUserNameById($post->getAuth());
        $userid = (!$this->getUser()) ? -1 : $this->getUser()->getUserID();

        return $this->render('BlogBundle:Page:postShow.html.twig',
            array(
            'post'     => $post,
            'author'   => $author,
            'username' => $this->getLoggedName(),
            'userid'   => $userid,
            )
        );
    }

    public function deleteAction($slug)
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $post = $this->getDoctrine()->getManager()
            ->getRepository('BlogBundle:BlogPost')
            ->find($slug);

        if ($post->getAuth() != $this->getUser()->getId()) {
            $this->get('session')->getFlashBag()->add('notice', '!!! You\'re not an author of this post, so you can\'t delete it!');
            return $this->redirectToRoute('post_show', array('slug' => $slug) );
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($post);
        $em->flush();

        return $this->redirectToRoute('blog_home');
    }

    public function editAction(Request $request, $slug)
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $form = $this->createForm('BlogBundle\Form\PostType');

        $em = $this->getDoctrine()->getManager();
        $post = $em->getRepository('BlogBundle:BlogPost')->find($slug);

        if ($post->getAuth() != $this->getUser()->getId()) {
            $this->get('session')->getFlashBag()->add('notice', '!!! You\'re not an author of this post, so you can\'t edit it!');
            return $this->redirectToRoute('post_show', array('slug' => $slug) );
        }

        $form->setData($post);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $post = $form->getData();
            $em->flush();
            $this->get('session')->getFlashBag()->add('notice', 'Post successfully updated.');
            return $this->redirectToRoute('post_show', array('slug' => $slug,) );
        }

        return $this->render('BlogBundle:Page:postEdit.html.twig',
            array(
            'form' => $form->createView(),
            'username' => $this->getLoggedName(),
            )
        );
    }

    public function newAction(Request $request)
    {
        $form = $this->createForm('BlogBundle\Form\PostType');

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $new_post = new BlogPost();
            $new_post = $form->getData();

            $new_post->setAuth( $this->getUser()->getId() );
            $new_post->setPostDate(new \DateTime);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($new_post);
            $entityManager->flush();

            $this->get('session')->getFlashBag()->add('notice', 'Post successfully created.');
            return $this->redirectToRoute('post_show', array('slug' => $new_post->getId() ));
        }

        return $this->render('BlogBundle:Page:postNew.html.twig',
            array(
            'form' => $form->createView(),
            'username' => $this->getLoggedName(),)
        );
    }

}