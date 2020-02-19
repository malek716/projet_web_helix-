<?php

namespace MalekBundle\Controller;

use MalekBundle\Entity\Reclamation;
use MalekBundle\Form\ReclamationType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction()
    {


        return $this->render('MalekBundle:Default:index.html.twig');
    }

        public function listReclamationbackAction(Request $request)
    {

        $listrec = $this->getDoctrine()->getRepository('MalekBundle:Reclamation')->findAll();

        $rec = $this->get('knp_paginator')->paginate(
            $listrec, $request->query->get('page',1)/*page number*/,
            4/*limit per page*/
        );
        return $this->render('MalekBundle:Default:listReclamation.html.twig', array(
            'rec' => $rec
        ));
    }


    public function listProduitFrontAction()
    {
        $produit = $this->getDoctrine()->getRepository('MalekBundle:Produit')->findAll();
        return $this->render('MalekBundle:Default:listProduitFront.html.twig', array(
            'produit' => $produit
        ));

    }

    public function traiterReclamationAction( $id)
    {

        $entityManager = $this->getDoctrine()->getManager();
        $rec = $entityManager->getRepository('MalekBundle:Reclamation')->find($id);


        if (!$rec) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }
        $rec->setEtat(true);
        $entityManager->flush();
        return $this->redirectToRoute('list_reclamation');

    }
    public function showReclamationbackAction( $id)
    {

        $entityManager = $this->getDoctrine()->getManager();
        $rec = $entityManager->getRepository('MalekBundle:Reclamation')->find($id);
        return $this->render('MalekBundle:Default:show.html.twig', array(
            'rec' => $rec
        ));
    }

    public function createReclamationAction(Request $request,$id){

        $produit = $this->getDoctrine()->getRepository('MalekBundle:Produit')->find($id);

        $rec = new Reclamation();
        $form = $this->createForm(ReclamationType::class, $rec);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $designation = $form['designation']->getData();
            $categorie = $form['categorie']->getData();
            $description = $form['description']->getData();
            $now = new\DateTime('now');

            $rec->setDesignation($designation);
            $rec->setCategorie($categorie);
            $rec->setDescription($description);
            $rec->setDate($now);
            $rec->setProduit($produit);
         //   $rec->setUtilisateur($user);
            $rec->setEtat(false);

            $sn = $this->getDoctrine()->getManager();
            $sn->persist($rec);
            $sn->flush();

            return $this->redirectToRoute('listProduitFront');
        }


        return $this->render('MalekBundle:Default:ajouterReclamation.html.twig',array(
            'form'=>$form->createView()
        ));
    }
    public function deleteReclamationAction($id)
    {

        $sn = $this->getDoctrine()->getManager();
        $rec = $sn->getRepository('MalekBundle:Reclamation')->find($id);
        $sn->remove($rec);
        $sn->flush();

        return $this->redirectToRoute('list_reclamation');

    }

    }
