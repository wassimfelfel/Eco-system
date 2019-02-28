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
     * @Route("admin/showadmin", name="showadmin_produits")
     */
    public function showadminAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $categorie = $em->getRepository('AppBundle:Categorie')->findAll();
        $produits = $em->getRepository('AppBundle:Produit')->findByCategorie($categorie);


        return $this->render('default/showadmin.html.twig', array(
            'produits' => $produits
        ));

    }





    /**
     * @Route("/societe/recyclage", name="societe_recyclage")
     */
    public function societeRecyclageAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager()->createQuery(
            'SELECT u FROM AppBundle:User u WHERE u.roles LIKE :role')
            ->setParameter('role', '%"ROLE_SOCIETE_RECYCLAGE"%');
        $recyclages = $em->getResult();
        $paginator  = $this->get('knp_paginator');
        $paginate= $paginator->paginate(
            $recyclages,
            $request->query->getInt('page', 1),
            2
        );

        //$recyclages = $em->getRepository('AppBundle:User')->findRecyclageCompanies('Role_SOCIETE_RECYCLAGE');
        return $this->render('default/societe_recylage.html.twig', array(
            'paginate' => $paginate
        ));
    }
    /**
     * @Route("/societe/reparation", name="societe_reparation")
     */
    public function societeReparationAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager()->createQuery(
            'SELECT u FROM AppBundle:User u WHERE u.roles LIKE :role')
            ->setParameter('role', '%"ROLE_SOCIETE_REPARATION"%');
        $reparations = $em->getResult();
        $paginator  = $this->get('knp_paginator');
        $paginate= $paginator->paginate(
            $reparations,
            $request->query->getInt('page', 1),
            2
        );
        //$reparations = $em->getRepository('AppBundle:User')->findRecyclageCompanies('Role_SOCIETE_REPARATION');
        return $this->render('default/societe_reparation.html.twig', array(
            'paginate' => $paginate
        ));
    }
    /**
     * @Route("/association/don", name="association_don")
     */
    public function AssociationDonAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager()->createQuery(
            'SELECT u FROM AppBundle:User u WHERE u.roles LIKE :role')
            ->setParameter('role', '%"ROLE_ASSOCIATION_DON"%');
        $dons = $em->getResult();
        $paginator  = $this->get('knp_paginator');
        $paginate= $paginator->paginate(
            $dons,
            $request->query->getInt('page', 1),
            2
        );
        //$dons = $em->getRepository('AppBundle:User')->findDonsCompanies('Role_ASSOCIATION');
        return $this->render('default/association_don.html.twig', array(
            'paginate' => $paginate
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
