<?php

namespace Paper\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;
use Paper\MainBundle\Entity\User;

class AuthController extends Controller
{
    /**
     * @Route("/login", name="login")
     * @Template()
     */
    public function loginAction()
    {

//        $manager = $this->getDoctrine()->getManager();
//        // создание пользователя
//        $user = new User();
//        $user->setUsername('admin');
//        $user->setSalt(md5(time()));
//        $encoder = new MessageDigestPasswordEncoder('sha512', true, 10);
//        $password = $encoder->encodePassword('wzcwzc', $user->getSalt());
//        $user->setPassword($password);
//
//        $user->setRoles('ROLE_ADMIN');
//        $user->setLastName('admin');
//        $user->setFirstName('admin');
//        $user->setSurName('admin');
//        $manager->persist($user);
//        $manager->flush($user);


//        $error = null;
//        if (!$this->get('request')->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
//            $error = 'Неправильный логин или пароль';
//        }
        if ($this->get('request')->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $this->get('request')->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = $this->get('request')->getSession()->get(SecurityContext::AUTHENTICATION_ERROR);
        }
//        var_dump($error);
//        exit;
        return array(
            'error' => $error
        );
    }





}
