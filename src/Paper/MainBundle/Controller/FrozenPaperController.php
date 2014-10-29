<?php
namespace Paper\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Request;
use Paper\MainBundle\Entity\FrozenPaper;
use Paper\MainBundle\Form\FrozenPaperType;

/**
 * Class FrozenPaperController
 * @package Paper\MainBundle\Controller
 * @Route("/frozenPaper")
 */
class FrozenPaperController extends Controller{
        const ENTITY_NAME = 'FrozenPaper';
    /**
     * @Security("has_role('ROLE_USER')")
     * @Route("/list/{orderId}/{error}", name="frozenPaper_list", defaults={"error" = "0"}, requirements = {"error" = "\d+"})
     * @Template()
     */
    public function listAction($orderId, $error = 0){
        $order = $this->getDoctrine()->getRepository('PaperMainBundle:Order')->findOneById($orderId);
        $items = $this->getDoctrine()->getRepository('PaperMainBundle:'.self::ENTITY_NAME)->findByOrder($order);

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $items,
            $this->get('request')->query->get('frozenPaper', 1),
            20
        );

        return array('pagination' => $pagination, 'orderId' => $orderId, 'error' => $error);
    }

    /**
     * @Security("has_role('ROLE_USER')")
     * @Route("/add/{orderId}", name="frozenPaper_add")
     * @Template()
     */
    public function addAction(Request $request, $orderId){
        $em = $this->getDoctrine()->getManager();
        $item = new FrozenPaper();
        $form = $this->createForm(new FrozenPaperType($em), $item);
        $formData = $form->handleRequest($request);
        $order = $this->getDoctrine()->getRepository('PaperMainBundle:Order')->findOneById($orderId);
        if ($request->getMethod() == 'POST'){
            if ($formData->isValid()){
                $item = $formData->getData();
                $item->setOrder($order);
                $em->persist($item);
                $em->flush();
                $em->refresh($item);
                return $this->redirect($this->generateUrl('frozenPaper_list',array('orderId'=>$orderId)));
            }
        }
        return array('form' => $form->createView());
    }

    /**
     * @Security("has_role('ROLE_USER')")
     * @Route("/edit/{orderId}/{id}", name="frozenPaper_edit")
     * @Template()
     */
    public function editAction(Request $request, $orderId, $id){
        $em = $this->getDoctrine()->getManager();
        $item = $this->getDoctrine()->getRepository('PaperMainBundle:'.self::ENTITY_NAME)->findOneById($id);
        $form = $this->createForm(new FrozenPaperType($em), $item);
        $formData = $form->handleRequest($request);
        $order = $this->getDoctrine()->getRepository('PaperMainBundle:Order')->findOneById($orderId);
        if ($request->getMethod() == 'POST'){
            if ($formData->isValid()){
                $item = $formData->getData();
                $item->setOrder($order);
                $em->flush($item);
                $em->refresh($item);
                return $this->redirect($this->generateUrl('frozenPaper_list',array('orderId'=>$orderId)));
            }
        }
        return array('form' => $form->createView(), 'orderId' => $orderId);
    }

    /**
     * @Security("has_role('ROLE_USER')")
     * @Route("/remove/{id}", name="frozenPaper_remove")
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
     * @Route("/status/{id}/{status}", name="frozenPaper_status")
     */
    public function statusAction(Request $request, $id, $status){
        $error = null;
        $em = $this->getDoctrine()->getManager();
        $item = $em->getRepository('PaperMainBundle:'.self::ENTITY_NAME)->findOneById($id);
        if ($item){
            # В отменен
            if ($status == 0){
                $paper = $item->getPaper();
                $paper->setCount($paper->getCount() + $item->getCount());
                $item->setStatus($status);
                $em->flush();
            }
            # В резерв
            if ($status == 1){
                $paper = $item->getPaper();
                if ($paper->getCount() - $item->getCount() >= 0){
                    $item->setStatus($status);
                    $em->flush();
                }else{
                    $item->setStatus($status);
                    $em->flush();
                    $error = 1;
                }
            }

            # В резерв
            if ($item->getStatus() == 1 && $status == 2){
                $paper = $item->getPaper();
                if ($paper->getCount() - $item->getCount() >= 0){
                    $paper->setCount($paper->getCount() - $item->getCount());
                    $item->setStatus($status);
                    $em->flush();
                }else{
                    $error = 2;
                }
            }

        }

        $orderId = $item->getOrder()->getId();
        return $this->redirect($this->generateUrl('frozenPaper_list', array('orderId' => $orderId, 'error' => $error)));
    }


}