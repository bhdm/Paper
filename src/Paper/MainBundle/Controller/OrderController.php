<?php
namespace Paper\MainBundle\Controller;

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
 * @Route("/")
 * @Route("/order")
 */
class OrderController extends Controller{
        const ENTITY_NAME = 'Order';
    /**
     * @Security("has_role('ROLE_USER')")
     * @Route("/{error}", name="order_list", defaults={"error" = "0"}, requirements = {"error" = "\d+"})
     * @Template()
     */
    public function listAction($error = 0){
        $items = $this->getDoctrine()->getRepository('PaperMainBundle:'.self::ENTITY_NAME)->findAll();

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $items,
            $this->get('request')->query->get('order', 1),
            500
        );

        return array('pagination' => $pagination, 'error' => $error);
    }

    /**
     * @Security("has_role('ROLE_USER')")
     * @Route("/add", name="order_add")
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
                $item->setUser($this->getUser());
                $em->persist($item);
                $em->flush();
                $em->refresh($item);
                return $this->redirect($this->generateUrl('order_edit', array('id' => $item->getId())));
            }
        }
        return array('form' => $form->createView());
    }

    /**
     * @Security("has_role('ROLE_USER')")
     * @Route("/edit/{id}", name="order_edit")
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
                return $this->redirect($this->generateUrl('order_list'));
            }
        }
        return array('form' => $form->createView(), 'id' => $id,'item' => $item);
    }

    /**
     * @Security("has_role('ROLE_USER')")
     * @Route("/remove/{id}", name="order_remove")
     */
    public function removeAction(Request $request, $id){
        $em = $this->getDoctrine()->getManager();
        $item = $em->getRepository('PaperMainBundle:'.self::ENTITY_NAME)->findOneById($id);

        if ($item){

            foreach ( $item->getPapers() as $frozen){
                $paper = $frozen->getPaper();

                if ($frozen->getStatus() == 1){
                    $paper->setFrozen($paper->getFrozen() - $frozen->getCount());
                }
                if ($item->getStatus() == 2){
                    $paper->setCount($paper->getCount() + $frozen->getCount());
                }
                $em->flush($paper);
                $em->remove($frozen);
                $em->flush();
            }

            $em->remove($item);
            $em->flush();
        }
        return $this->redirect($request->headers->get('referer'));
    }

    /**
     * @Security("has_role('ROLE_USER')")
     * @Route("/status/{id}/{status}", name="paper_status")
     */
    public function statusAction(Request $request, $id, $status){
        $error = 0;
        $em = $this->getDoctrine()->getManager();
        $item = $em->getRepository('PaperMainBundle:'.self::ENTITY_NAME)->findOneById($id);
        if ($status == 2 && !$item->isAllHold()){
            $error = 1;
        }else{
            if ($item){
                $item->setStatus($status);
                $em->flush();
            }
        }
        return $this->redirect($this->generateUrl('order_list', array('error' => $error)));
    }
}