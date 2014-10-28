<?php
namespace Paper\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Request;
use Paper\MainBundle\Entity\Order;
use Paper\MainBundle\Form\OrderType;

/**
 * Class OrderController
 * @package Paper\MainBundle\Controller
 * @Route("/order")
 */
class OrderController extends Controller{
        const ENTITY_NAME = 'Order';
    /**
     * @Security("has_role('IS_AUTHENTICATED_REMEMBERED')")
     * @Route("/", name="admin_order_list")
     * @Template()
     */
    public function listAction(){
        $items = $this->getDoctrine()->getRepository('PaperMainBundle:'.self::ENTITY_NAME)->findAll();

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $items,
            $this->get('request')->query->get('order', 1),
            20
        );

        return array('pagination' => $pagination);
    }

    /**
     * @Security("has_role('IS_AUTHENTICATED_REMEMBERED')")
     * @Route("/add", name="admin_order_add")
     * @Template()
     */
    public function addAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $item = new Order();
        $form = $this->createForm(new OrderType($em), $item);
        $formData = $form->handleRequest($request);

        if ($request->getMethod() == 'POST'){
            if ($formData->isValid()){
                $item = $formData->getData();
                $em->persist($item);
                $em->flush();
                $em->refresh($item);
                return $this->redirect($this->generateUrl('admin_order_list'));
            }
        }
        return array('form' => $form->createView());
    }

    /**
     * @Security("has_role('IS_AUTHENTICATED_REMEMBERED')")
     * @Route("/edit/{id}", name="admin_order_edit")
     * @Template()
     */
    public function editAction(Request $request, $id){
        $em = $this->getDoctrine()->getManager();
        $item = $this->getDoctrine()->getRepository('PaperMainBundle:'.self::ENTITY_NAME)->findOneById($id);
        $form = $this->createForm(new OrderType($em), $item);
        $formData = $form->handleRequest($request);

        if ($request->getMethod() == 'POST'){
            if ($formData->isValid()){
                $item = $formData->getData();
                $em->flush($item);
                $em->refresh($item);
                return $this->redirect($this->generateUrl('admin_order_list'));
            }
        }
        return array('form' => $form->createView());
    }

    /**
     * @Security("has_role('IS_AUTHENTICATED_REMEMBERED')")
     * @Route("/remove/{id}", name="admin_order_remove")
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