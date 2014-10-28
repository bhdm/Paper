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
         * 5 Всего ЧБ кликов
         * 6 Всего цветных кликов
         * 7 Всего односторонних
         * 8 Всего двухсторонних
         */
        $f = array(
            '1' => 0,
            '2' => 0,
            '3' => 0,
            '4' => 0,
            '5' => 0,
            '6' => 0,
            '7' => 0,
            '8' => 0,
        );
        $order = array(
            '1' => count($this->getDoctrine()->getRepository('PaperMainBundle:Order')->findByEnabled(true)),
            '2' => count($this->getDoctrine()->getRepository('PaperMainBundle:Order')->findBy(array('enabled'=>true, 'status' => 0))),
            '3' => count($this->getDoctrine()->getRepository('PaperMainBundle:Order')->findBy(array('enabled'=>true, 'status' => 1))),
            '4' => count($this->getDoctrine()->getRepository('PaperMainBundle:Order')->findBy(array('enabled'=>true, 'status' => 2))),
        );

        foreach ($frozens as $item){
            if ($item->getColor() == false && $item->getTypePrint() == 1){ $f['1'] += $item->getCount(); $f['7'] += $item->getCount(); $f['5'] += $item->getCount(); }
            if ($item->getColor() == false && $item->getTypePrint() == 2){ $f['2'] += $item->getCount(); $f['8'] += $item->getCount(); $f['5'] += $item->getCount()*2; }
            if ($item->getColor() == true && $item->getTypePrint() == 1) { $f['3'] += $item->getCount(); $f['7'] += $item->getCount(); $f['6'] += $item->getCount(); }
            if ($item->getColor() == true && $item->getTypePrint() == 2) { $f['4'] += $item->getCount(); $f['8'] += $item->getCount(); $f['6'] += $item->getCount()*2; }

        }


        return array('forzens' => $frozens, 'stats' => $f, 'orders' => $orders,'order' => $order);
    }
}