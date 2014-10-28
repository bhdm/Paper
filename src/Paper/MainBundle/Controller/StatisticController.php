<?php
namespace Paper\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class UserController
 * @package Paper\MainBundle\Controller
 * @Route("/statistic")
 */
class StatisticController extends Controller{

    /**
     * @Security("has_role('ROLE_ADMIN')")
     * @Route("/", name="statistic_list")
     * @Template()
     */
    public function indexAction(){
        $frozens = $this->getDoctrine()->getRepository('PaperMainBundle:FrozenPaper')->findByEnabled(true);
        $orders = $this->getDoctrine()->getRepository('PaperMainBundle:Order')->findByEnabled(true);

        /**
         * 1 ЧБ односторонняя
         * 2 ЧБ двухсторонняя
         * 3 цветная односторонняя
         * 4 цветная двухсторонняя
         */
        $f = array(
            '1' => count($orders = $this->getDoctrine()->getRepository('PaperMainBundle:Order')->findByEnabled(true)),
            '2' => 0,
            '3' => 0,
            '4' => 0
        );

        foreach ($frozens as $item){

        }


        return array('forzens' => $frozens, 'stats' => $f, 'orders' => $orders);
    }
}