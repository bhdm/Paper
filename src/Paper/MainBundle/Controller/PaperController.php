<?php
namespace Paper\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Request;
use Paper\MainBundle\Entity\Paper;
use Paper\MainBundle\Form\PaperType;

/**
 * Class PaperController
 * @package Paper\mainBundle\Controller
 * @Route("/paper")
 */
class PaperController extends Controller{
        const ENTITY_NAME = 'Paper';
    /**
     * @Security("has_role('ROLE_USER')")
     * @Route("/", name="paper_list")
     * @Template()
     */
    public function listAction(){
        $items = $this->getDoctrine()->getRepository('PaperMainBundle:'.self::ENTITY_NAME)->findAll();

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $items,
            $this->get('request')->query->get('paper', 1),
            20
        );

        return array('pagination' => $pagination, 'papers' => $items);
    }

    /**
     * @Security("has_role('ROLE_USER')")
     * @Route("/add", name="paper_add")
     * @Template()
     */
    public function addAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $item = new Paper();
        $form = $this->createForm(new PaperType($em), $item);
        $formData = $form->handleRequest($request);

        if ($request->getMethod() == 'POST'){
            if ($formData->isValid()){
                $item = $formData->getData();
                $em->persist($item);
                $em->flush();
                $em->refresh($item);
                return $this->redirect($this->generateUrl('paper_list'));
            }
        }
        return array('form' => $form->createView());
    }

    /**
     * @Security("has_role('ROLE_PRESSMAN')")
     * @Route("/edit/{id}", name="paper_edit")
     * @Template()
     */
    public function editAction(Request $request, $id){
        $em = $this->getDoctrine()->getManager();
        $item = $this->getDoctrine()->getRepository('PaperMainBundle:'.self::ENTITY_NAME)->findOneById($id);
        $form = $this->createForm(new PaperType($em), $item);
        $formData = $form->handleRequest($request);

        if ($request->getMethod() == 'POST'){
            if ($formData->isValid()){
                $item = $formData->getData();
                $em->flush($item);
                $em->refresh($item);
                return $this->redirect($this->generateUrl('paper_list'));
            }
        }
        return array('form' => $form->createView());
    }

    /**
     * @Security("has_role('ROLE_ADMIN')")
     * @Route("/remove/{id}", name="paper_remove")
     */
    public function removeAction(Request $request, $id){
        $em = $this->getDoctrine()->getManager();
        $item = $em->getRepository('PaperMainBundle:'.self::ENTITY_NAME)->findOneById($id);
        if ($item){
            $em->remove($item);
            $em->flush();
        }
        return $this->redirect($request->headers->get('referer'));
    }

    /**
     * @Security("has_role('ROLE_PRESSMAN')")
     * @Route("/addCount", name="paper_addcount")
     */
    public function addCountAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        if ($request->getMethod() == 'POST'){
            $id = $request->request->get('paperId');
            $count = $request->request->get('paperCount');
            $paper = $em->getRepository('PaperMainBundle:Paper')->findOneById($id);
            $paper->setCount($paper->getCount()+$count);
            $em->flush($paper);
        }
        return $this->redirect($request->headers->get('referer'));
    }

    /**
     * @Security("has_role('ROLE_USER')")
     * @Route("/getcount", name="paper_getcount", options={"expose" = true })
     */
    public function getCountAction(Request $request){
        if ($request->getMethod() == 'POST'){
            $paperId = $request->request->get('paper');
            $paper = $this->getDoctrine()->getRepository('PaperMainBundle:Paper')->findOneById($paperId);
            $response =  new Response($paper->getCount());
            return $response;
        }else{
            $response =  new Response('0');
            return $response;
        }
    }

}