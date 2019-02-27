<?php

namespace EventsBundle\Controller;

use AppBundle\Entity\User;
use EventsBundle\Entity\Archive;
use EventsBundle\Entity\categories;
use EventsBundle\Entity\Events;
use EventsBundle\Form\categoriesType;
use EventsBundle\Form\EventsType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('EventsBundle:Default:index.html.twig');
    }
    public function AjouterEventAction(\Symfony\Component\HttpFoundation\Request $request)
    {
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $Events = new Events();
        $form = $this->createForm(EventsType::class, $Events);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $Events->setUser($user);

            /**
             * @var UploadedFile $file
             */
            $file=$Events->getImage();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            $file->move(
                $this->getParameter('image_directory'),$fileName
            );
            $Events->setImage($fileName);


            $em->persist($Events);
            $em->flush();
            return $this->redirectToRoute("AfficherEvent");
        }
        return $this->render("@Events/Default/AjouterEvent.html.twig", array('form' => $form->createView()));
    }
    public function AfficherEventAction()
    {
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $Events = $this->getDoctrine()->getRepository(Events::class)->findBy(array('user' => $user));


        return $this->render("@Events/Default/AfficherEvent.html.twig", array('Events' => $Events));
    }
    public function AfficherToutEventAction()
    {

        $Events = $this->getDoctrine()->getRepository(Events::class)->findAll();


        return $this->render("@Events/Default/AfficherToutEvent.html.twig", array('Events' => $Events));
    }
    public function ad_AfficherToutEventAction()
    {

        $Events = $this->getDoctrine()->getRepository(Events::class)->findAll();


        return $this->render("@Events/Default/ad_AfficherToutEvent.html.twig", array('Events' => $Events));
    }
    public function SupprimerEventAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $post = $em->getRepository(Events::class)->find($id);
        $em->remove($post);
        $em->flush();
        return $this->redirectToRoute("AfficherEvent");
    }
    public function ModifierEventAction($id,\Symfony\Component\HttpFoundation\Request $request){
        $Event=$this->getDoctrine()->getRepository(Events::class)->find($id);
        $form=$this->createForm(EventsType::class,$Event);
        $form->handleRequest($request);
        if ($form->isValid()){
            $e = $this->getDoctrine()->getManager();
            $e->flush();
            return $this->redirectToRoute("AfficherEvent");
        }
        return $this->render("@Events/Default/ModifierEvent.html.twig",array("form"=>$form->createView()));



    }
    public function Afficher1EventAction($id)
    {
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $Events = $this->getDoctrine()->getRepository(Events::class)->find($id);
        return $this->render("@Events/Default/Afficher1Event.html.twig", array('Events' => $Events));
    }
    //CRUD Categories
    public function AjouterCategorieAction(\Symfony\Component\HttpFoundation\Request $request)
    {
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $Categorie = new categories();
        $form = $this->createForm(categoriesType::class, $Categorie);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $Categorie->setUser($user);
            $em->persist($Categorie);
            $em->flush();
            return $this->redirectToRoute("AfficherCategorie");
        }
        return $this->render("@Events/Default/AjouterCategorie.html.twig", array('form' => $form->createView()));
    }
    public function AfficherCategorieAction()
    {

        $categories = $this->getDoctrine()->getRepository(categories::class)->findAll();


        return $this->render("@Events/Default/AfficherCategorie.html.twig", array('categories' => $categories));
    }
    public function SupprimerCategorieAction($idcat)
    {
        $em = $this->getDoctrine()->getManager();
        $post = $em->getRepository(categories::class)->find($idcat);
        $em->remove($post);
        $em->flush();
        return $this->redirectToRoute("AfficherCategorie");
    }
    public function ModifierCategorieAction($idcat,\Symfony\Component\HttpFoundation\Request $request){
        $categories=$this->getDoctrine()->getRepository(categories::class)->find($idcat);
        $form=$this->createForm(categoriesType::class,$categories);
        $form->handleRequest($request);
        if ($form->isValid()){
            $e = $this->getDoctrine()->getManager();
            $e->flush();
            return $this->redirectToRoute("AfficherCategorie");
        }
        return $this->render("@Events/Default/ModifierCategorie.html.twig",array("form"=>$form->createView()));



    }
    public function ArchiverEventAction($id)
    {

        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $Archive=new Archive();
        $Events=$this->getDoctrine()->getRepository(Events::class)->find($id);
        $categ = $Events->getCategories();
        $ajouterpar = $Events->getUser();
        $Categories=$this->getDoctrine()->getRepository(categories::class)->find($categ);
        $utilisateur=$this->getDoctrine()->getRepository(User::class)->find($ajouterpar);
        $em = $this->getDoctrine()->getManager();

        $nomevent = $Events->getTitre();

        $catego=$Categories->getNom();
        $userr=$utilisateur->getId();
        $description = $Events->getDescription();
        $numtel = $Events->getNumtel();
        $email = $Events->getEmail();
        $date = $Events->getDate();
        $adresse = $Events->getAdresse();


        $Archive->setUser($user);
        $Archive->setNomEvent($nomevent);
        $Archive->setAjouterPar($userr);
        $Archive->setDescription($description);
        $Archive->setNumTel($numtel);
        $Archive->setEmail($email);
        $Archive->setDate($date);
        $Archive->setAdresse($adresse);
        $Archive->setCategorie($catego);
        $post = $em->getRepository(Events::class)->find($id);

        $em->persist($Archive);
        $em->remove($post);
        $em->flush();
        return $this->redirectToRoute("ad_AfficherToutEvent");
    }

}
