<?php
namespace Paper\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\DateTime;

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
    public function indexAction(Request $request){

        if ($request->getMethod() == 'POST'){
            $starts  = $request->request->get('datetimepicker1');
            $ends    = $request->request->get('datetimepicker2');
        }else{
            $starts = 'now';
            $ends = 'now';
        }


        $ends = new \DateTime($ends);
        if ($starts == 'now'){
            $starts = new \DateTime($starts);
            $starts->modify('-1 month');
        }else{
            $starts = new \DateTime($starts);
        }


        $frozens = $this->getDoctrine()->getRepository('PaperMainBundle:FrozenPaper')->filter($starts,$ends);
        $orders = $this->getDoctrine()->getRepository('PaperMainBundle:Order')->findByEnabled(true);

        /**
         * 0 Всего ЧБ кликов
         * 1 Всего цветных кликов
         */
        $f = array();

        $order = array(
            '1' => count($this->getDoctrine()->getRepository('PaperMainBundle:Order')->findByEnabled(true)),
            '2' => count($this->getDoctrine()->getRepository('PaperMainBundle:Order')->findBy(array('enabled'=>true, 'status' => 0))),
            '3' => count($this->getDoctrine()->getRepository('PaperMainBundle:Order')->findBy(array('enabled'=>true, 'status' => 1))),
            '4' => count($this->getDoctrine()->getRepository('PaperMainBundle:Order')->findBy(array('enabled'=>true, 'status' => 2))),
        );

        foreach ($frozens as $item){
            if ($item->getStatus() == 2){
                if (!isset($f[$item->getPrinter()->getTitle()])) $f[$item->getPrinter()->getTitle()] = array('0' => 0, '1' => 0);
                if ($item->getTypePrint() == 4){ $f[$item->getPrinter()->getTitle()]['0'] += $item->getCount(); }
                if ($item->getTypePrint() == 3){ $f[$item->getPrinter()->getTitle()]['0'] += $item->getCount()*2; }
                if ($item->getTypePrint() == 2) { $f[$item->getPrinter()->getTitle()]['1'] += $item->getCount(); }
                if ($item->getTypePrint() == 1) { $f[$item->getPrinter()->getTitle()]['1'] += $item->getCount()*2; }
                if ($item->getTypePrint() == 5) { $f[$item->getPrinter()->getTitle()]['0'] += $item->getCount(); $f[$item->getPrinter()->getTitle()]['1'] += $item->getCount(); }

            }
        }


        return array(
            'forzens' => $frozens,
            'stats' => $f,
            'orders' => $orders,
            'order' => $order,
            'starts' => $starts,
            'ends' => $ends,
        );
    }
}