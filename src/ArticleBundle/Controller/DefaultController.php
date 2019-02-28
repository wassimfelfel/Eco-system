<?php

namespace ArticleBundle\Controller;

use ArticleBundle\Entity\Article;
use ArticleBundle\Entity\commentaire;
use ArticleBundle\Form\ArticleType;
use ArticleBundle\Form\commentaireType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('ArticleBundle:Default:index.html.twig');
    }

    public function AjouterArticleAction(\Symfony\Component\HttpFoundation\Request $request)
    {
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $Article = new Article();
        $form = $this->createForm(ArticleType::class, $Article);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $Article->setUser($user);
            $Article->setVue(0);
            $Article->setAuteur($this->getUser());
            $Article->setDate(new \DateTime('now'));

            $em->persist($Article);
            $em->flush();
            return $this->redirectToRoute("AfficherArticle");
        }
        return $this->render("@Article/Default/AjouterArticle.html.twig", array('form' => $form->createView()));
    }

    public function AfficherArticleAction()
    {
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $Article = $this->getDoctrine()->getRepository(Article::class)->findAll();
        return $this->render("@Article/Default/AfficherArticle.html.twig", array('Article' => $Article));
    }

    public function SupprimerArticleAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $post = $em->getRepository(Article::class)->find($id);
        $em->remove($post);
        $em->flush();
        return $this->redirectToRoute("AfficherArticle");
    }

    public function ModifierArticleAction($id, \Symfony\Component\HttpFoundation\Request $request)
    {
        $Article = $this->getDoctrine()->getRepository(Article::class)->find($id);
        $form = $this->createForm(ArticleType::class, $Article);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $e = $this->getDoctrine()->getManager();
            $e->flush();
            return $this->redirectToRoute("AfficherArticle");
        }
        return $this->render("@Article/Default/ModifierArticle.html.twig", array("form" => $form->createView()));


    }

    public function ArticleAction($id, \Symfony\Component\HttpFoundation\Request $request)
    {
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $Article = $this->getDoctrine()->getRepository(Article::class)->find($id);
        $Commentaires = $this->getDoctrine()->getRepository(commentaire::class)->findBy(array('Article' => $Article));

        $commentaire = new commentaire();
        $form = $this->createForm(commentaireType::class, $commentaire);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $commentaire->setUser($user);
            $commentaire->setArticle($Article);

             $commentaire->setAuteur($this->getUser());
             $commentaire->setDate(new \DateTime('now'));

            $em->persist($commentaire);
            $em->flush();
            return $this->redirectToRoute("Article",array('id'=>$id));



        }
        return $this->render("@Article/Default/Article.html.twig", array('Article' => $Article,'Commentaires' => $Commentaires,'form' => $form->createView()));


    }
}
