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
class FrozenStatisticController extends Controller
{

    /**
     * @Security("has_role('ROLE_ADMIN')")
     * @Route("/frozen", name="frozen_list")
     * @Template("PaperMainBundle:Statistic:frozen.html.twig")
     */
    public function indexAction(Request $request)
    {
        $orders = $this->getDoctrine()->getRepository('PaperMainBundle:Order')->findAll();

        return array('orders' => $orders);
    }
}
