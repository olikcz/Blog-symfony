<?php
/**
 * Created by PhpStorm.
 * User: BOSS
 * Date: 27.05.2019
 * Time: 12:36
 */

namespace AppBundle\TermBundle\Controller;


use AppBundle\TermBundle\Entity\Term;
use AppBundle\TermBundle\Forms\TermDeleteForm;
use AppBundle\TermBundle\Forms\TermForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class TermController extends Controller
{
    public function listAction(){
        $terms = $this->getDoctrine()->getRepository('TermBundle:Term')->findAll();
        return $this->render('@Term/Page/list.html.twig',[
            'terms' => $terms
        ]);
    }
    public function addAction(Request $request){
        $term = new Term();
        $form = $this->createForm(TermForm::class, $term);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($term);
            $em->flush();
            $this->addFlash('success', 'Category created successfully!');
            return  $this->redirectToRoute('admin_page');
        }
        return $this->render('@Term/Page/add.html.twig',
            [
                'form' => $form->createView()
            ]);
    }

    public function viewAction($id){
        $em = $this->getDoctrine()->getManager();
        $termRepo = $em->getRepository('TermBundle:Term');
        $term = $termRepo->find($id);
        if(!$term){
            throw $this->createNotFoundException('The page doest not exist.');
        }
        return $this->render('@Term/Page/view.html.twig',
            [
                'term' => $term
            ]);
    }

    public function editAction($id, Request $request){
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('TermBundle:Term');
        $term = $repo->find($id);
        if(!$term){
            return  $this->redirectToRoute('term_list');
        }
        $form = $this->createForm(TermForm::class, $term);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em->persist($term);
            $em->flush();
            return  $this->redirectToRoute('term_view', [
                'id' => $term->getId()
            ]);
        }
        return $this->render('@Term/Page/edit.html.twig', [
            'form' => $form->createView()
        ]);


    }

    public function removeAction($id, Request $request){
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('TermBundle:Term');
        $term = $repo->find($id);
        if(!$term){
            return  $this->redirectToRoute('page_list');
        }
        $form = $this->createForm(TermDeleteForm::class, null,[
            'delete_id' => $term->getId()
        ]);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em->remove($term);
            $em->flush();
            // $this->addFlash('notice', 'Deleted Successfully!');
            return  $this->redirectToRoute('term_list');

        }
        return $this->render('@Term/Page/delete.html.twig', [
            'form' => $form->createView(),
            'term' => $term
        ]);
    }
}