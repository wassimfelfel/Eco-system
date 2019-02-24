<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/vente", name="vente_products")
     */
    public function venteAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $categorie = $em->getRepository('AppBundle:Categorie')->findOneByNom('A vendre');
        $produits = $em->getRepository('AppBundle:Produit')->findByCategorie($categorie);

        $paginator  = $this->get('knp_paginator');
        $paginateProducts = $paginator->paginate(
            $produits,
            $request->query->getInt('page', 1),
            2
        );
        return $this->render('default/vente.html.twig', array(
            'paginateProducts' => $paginateProducts
        ));
    }

    /**
     * @Route("/recyclage", name="recyclage_products")
     */
    public function recyclageAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $categorie = $em->getRepository('AppBundle:Categorie')->findOneByNom('A recycler');
        $produits = $em->getRepository('AppBundle:Produit')->findByCategorie($categorie);
        $paginator  = $this->get('knp_paginator');
        $paginateProducts = $paginator->paginate(
            $produits,
            $request->query->getInt('page', 1),
            2
        );
        return $this->render('default/recyclage.html.twig', array(
            'paginateProducts' => $paginateProducts
        ));
    }

    /**
     * @Route("/reparation", name="reparation_products")
     */
    public function reparationAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $categorie = $em->getRepository('AppBundle:Categorie')->findOneByNom('A reparer');
        $produits = $em->getRepository('AppBundle:Produit')->findByCategorie($categorie);
        $paginator  = $this->get('knp_paginator');
        $paginateProducts = $paginator->paginate(
            $produits,
            $request->query->getInt('page', 1),
            2
        );
        return $this->render('default/reparation.html.twig', array(
            'paginateProducts' => $paginateProducts
        ));
    }

    /**
     * @Route("/don", name="don_products")
     */
    public function donAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $categorie = $em->getRepository('AppBundle:Categorie')->findOneByNom('A donner');
        $produits = $em->getRepository('AppBundle:Produit')->findByCategorie($categorie);
        $paginator  = $this->get('knp_paginator');
        $paginateProducts = $paginator->paginate(
            $produits,
            $request->query->getInt('page', 1),
            2
        );
        return $this->render('default/don.html.twig', array(
            'paginateProducts' => $paginateProducts
        ));

    }

    /**
     * @Route("/admin", name="adminpage")
     */
    public function adminAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('@User/default/admin.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }
}
