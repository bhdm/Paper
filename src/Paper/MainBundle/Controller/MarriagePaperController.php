<?php
namespace Paper\MainBundle\Controller;

use Paper\MainBundle\Entity\MarriagePaper;
use Paper\MainBundle\Form\MarriagePaperType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class MarriagePaperController
 * @package Paper\MainBundle\Controller
 * @Route("/marriagePaper")
 */
class MarriagePaperController extends Controller{
        const ENTITY_NAME = 'MarriagePaper';
    /**
     * @Security("has_role('ROLE_USER')")
     * @Route("/list/{orderId}/{error}", name="marriagePaper_list", defaults={"error" = "0"}, requirements = {"error" = "\d+"})
     * @Template()
     */
    public function listAction($orderId, $error = 0){
        $order = $this->getDoctrine()->getRepository('PaperMainBundle:Order')->findOneById($orderId);
        $items = $this->getDoctrine()->getRepository('PaperMainBundle:'.self::ENTITY_NAME)->findByOrder($order);

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $items,
            $this->get('request')->query->get('MarriagePaper', 1),
            500
        );

        return array('pagination' => $pagination, 'orderId' => $orderId, 'error' => $error, 'order' => $order);
    }

    /**
     * @Security("has_role('ROLE_USER')")
     * @Route("/add/{orderId}", name="marriagePaper_add")
     * @Template()
     */
    public function addAction(Request $request, $orderId){
        $em = $this->getDoctrine()->getManager();
        $item = new MarriagePaper();
        $form = $this->createForm(new MarriagePaperType($em), $item);
        $formData = $form->handleRequest($request);
        $order = $this->getDoctrine()->getRepository('PaperMainBundle:Order')->findOneById($orderId);
        if ($request->getMethod() == 'POST'){
            if ($formData->isValid()){
                $item = $formData->getData();
                $item->setOrder($order);
                $em->persist($item);
                $paper = $item->getPaper();
                $error = 0;
                if ($paper->getCount() < $paper->getMarriage() ){
                    $error = 1;
                }
                $em->flush();
                $em->refresh($item);
                return $this->redirect($this->generateUrl('marriagePaper_list',array('orderId'=>$orderId, 'error' => $error)));
            }
        }
        return array('form' => $form->createView());
    }

    /**
     * @Security("has_role('ROLE_USER')")
     * @Route("/edit/{orderId}/{id}", name="marriagePaper_edit")
     * @Template()
     */
    public function editAction(Request $request, $orderId, $id){
        $em = $this->getDoctrine()->getManager();
        $item = $this->getDoctrine()->getRepository('PaperMainBundle:'.self::ENTITY_NAME)->findOneById($id);
        $form = $this->createForm(new MarriagePaperType($em), $item);
        $formData = $form->handleRequest($request);
        $order = $this->getDoctrine()->getRepository('PaperMainBundle:Order')->findOneById($orderId);
        if ($request->getMethod() == 'POST'){
            if ($formData->isValid()){
                $item = $formData->getData();
                $item->setOrder($order);
                $em->flush($item);
                $em->refresh($item);
                return $this->redirect($this->generateUrl('marriagePaper_list',array('orderId'=>$orderId)));
            }
        }
        return array('form' => $form->createView(), 'orderId' => $orderId);
    }

    /**
     * @Security("has_role('ROLE_USER')")
     * @Route("/remove/{id}", name="marriagePaper_remove")
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

}