<?php

namespace ArticleBundle\Controller;

use ArticleBundle\Entity\Article;
use ArticleBundle\Entity\commentaire;
use ArticleBundle\Entity\Favoris;
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
            $Article->setNbcom(0);
            $Article->setAuteur($this->getUser());
            $Article->setDate(new \DateTime('now'));

            $em->persist($Article);
            $em->flush();
            return $this->redirectToRoute("AfficherArticle");
        }
        return $this->render("@Article/Default/AjouterArticle.html.twig", array('form' => $form->createView()));
    }

    public function AfficherArticleAction(\Symfony\Component\HttpFoundation\Request $request)
    {
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $Article = $this->getDoctrine()->getRepository(Article::class)->findAll();


        $paginator  = $this->get('knp_paginator');
        $paginateProducts = $paginator->paginate(
            $Article,
            $request->query->getInt('page', 1),
            5
        );
        return $this->render('@Article/Default/AfficherArticle.html.twig', array(
            'paginateProducts' => $paginateProducts,'Article' => $Article,'user' =>$user
        ));
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
        $this->Nbvues($id);
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $Article = $this->getDoctrine()->getRepository(Article::class)->find($id);
        $Commentaires = $this->getDoctrine()->getRepository(commentaire::class)->findBy(array('Article' => $Article));

        $com=$Article->getNbcom();
        $Article->setNbcom($com +1);
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
            return $this->redirectToRoute("Article",array('id'=>$id,'user'=>$user));



        }
        return $this->render("@Article/Default/Article.html.twig", array('user'=>$user,'Article' => $Article,'Commentaires' => $Commentaires,'form' => $form->createView()));


    }

    public function SupprimerCommentaireAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $post = $em->getRepository(commentaire::class)->find($id);
        $liji = $post->getArticle();
        $lojo=$this->getDoctrine()->getRepository(Article::class)->find($liji);
        $Article = $this->getDoctrine()->getRepository(Article::class)->find($lojo);
        $com=$Article->getNbcom();
        $Article->setNbcom($com -1);
        $em->remove($post);
        $em->flush();
        return $this->redirectToRoute("AfficherArticle");
    }


    public function Nbvues($id){
        $Article = $this->getDoctrine()->getRepository(Article::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        $Nbvue=$Article->getVue();
        $Article->setVue($Nbvue +1);
        $em->persist($Article);
        $em->flush();

    }

    public function ModifierCommentaireAction($id, \Symfony\Component\HttpFoundation\Request $request)
    {
        $commentaire = $this->getDoctrine()->getRepository(commentaire::class)->find($id);
        $form = $this->createForm(commentaireType::class, $commentaire);
        $Article = $commentaire->getArticle();
        $im=$Article->getId();

        $form->handleRequest($request);
        if ($form->isValid()) {
            $e = $this->getDoctrine()->getManager();
            $e->flush();
            return $this->redirectToRoute("AfficherArticle");
        }
        return $this->render("@Article/Default/ModifierCommentaire.html.twig", array("form" => $form->createView()));


    }

    public function MesArticlesAction()
    {
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $Article = $this->getDoctrine()->getRepository(Article::class)->findAll();
        return $this->render("@Article/Default/MesArticles.html.twig", array('Article' => $Article,'user' =>$user));
    }

        public function AdminAfficherArticleAction()
    {
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $Article = $this->getDoctrine()->getRepository(Article::class)->findAll();
        return $this->render("@Article/Default/AdminAfficherArticle.html.twig", array('Article' => $Article,'user' =>$user));
    }

    public function AdminSupprimerArticleAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $post = $em->getRepository(Article::class)->find($id);
        $em->remove($post);
        $em->flush();
        return $this->redirectToRoute("AdminAfficherArticle");
    }

    public function AdminArticleAction($id, \Symfony\Component\HttpFoundation\Request $request)
    {
        $this->Nbvues($id);
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $Article = $this->getDoctrine()->getRepository(Article::class)->find($id);
        $Commentaires = $this->getDoctrine()->getRepository(commentaire::class)->findBy(array('Article' => $Article));

        $com=$Article->getNbcom();
        $Article->setNbcom($com +1);
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
            return $this->redirectToRoute("AdminArticle",array('id'=>$id,'user'=>$user));



        }
        return $this->render("@Article/Default/AdminArticle.html.twig", array('user'=>$user,'Article' => $Article,'Commentaires' => $Commentaires,'form' => $form->createView()));


    }

    public function AdminSupprimerCommentaireAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $post = $em->getRepository(commentaire::class)->find($id);
        $liji = $post->getArticle();
        $lojo=$this->getDoctrine()->getRepository(Article::class)->find($liji);
        $Article = $this->getDoctrine()->getRepository(Article::class)->find($lojo);
        $com=$Article->getNbcom();
        $Article->setNbcom($com -1);
        $em->remove($post);
        $em->flush();
        return $this->redirectToRoute("AdminAfficherArticle");
    }

    public function LikeAction(Article $article )
    {
        $favorie = new Favoris();
        $user= $this->getUser();
        $favorie->setUser($user);
        $favorie->setArticle($article);
        $em = $this->getDoctrine()->getManager();
        $em->persist($favorie);
        $em->flush();

        return "liked";
    }


    public function DisLikeAction(Article $article )
    {
        $user= $this->getUser();
        $em = $this->getDoctrine()->getManager();

        $favorie=$em->getRepository("ArticleBundle:Favoris")->findOneBy(
            array(
                "user" => $user,
                "article" => $article
            )
        );
        $em->remove($favorie);
        $em->flush();

        return "disliked";

    }


    public function isLiked(Article $article )
    {
        $user= $this->getUser();
        $em = $this->getDoctrine()->getManager();

        $favorie=$em->getRepository("ArticleBundle:Favoris")->findOneBy(
            array(
                "user" => $user,
                "article" => $article
            )
        );
        return $favorie != null;
    }


}
