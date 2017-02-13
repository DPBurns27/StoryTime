<?php

namespace AppBundle\Controller;

use AppBundle\Form\UserType;
use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;



class LoginController extends Controller
{
    /**
     * @Route("/login", name="login")
     */
    public function loginAction(Request $request)
    {


            //if ($form->get('login')->isClicked()) {

//                $authenticationUtils = $this->get('security.authentication_utils');
//
//                // get the login error if there is one
//                $error = $authenticationUtils->getLastAuthenticationError();
//
//                // last username entered by the user
//                $lastUsername = $authenticationUtils->getLastUsername();
//
//                $varsForView['last_username'] = $lastUsername;
//                $varsForView['error'] = $error;

                //TODO: implement error reporting for failed user logins

//                return $this->redirectToRoute('homepage');
            //}

            // Redirect them when they have signed up
            //return $this->redirectToRoute();
        //}

        //$varsForView['form'] = $form->createView();
//        return $this->render(
//            'Login/login.html.twig',
//            $varsForView
//        );
        return $this->render('Login/login.html.twig');


    }

    /**
     * @Route("/login_check", name="login_check")
     */
    public function loginCheckAction (Request $request) {

    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logoutAction (Request $request) {

    }

    /**
     * @Route("/signup", name="signup")
     */
    public function registerAction (Request $request) {
        // Logging
        $input = $request->request->all();
        $this->get("logger")->info(json_encode($input));

        $user = new User();

        $user->setUsername($input['_username']);
        $user->setPlainPassword($input['_password']);

        $encoder = $this->get('security.password_encoder');
        $password = $encoder->encodePassword($user, $user->getPlainPassword());
        $user->setPassword($password);

        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
        $this->get('security.token_storage')->setToken($token);
        $this->get('session')->set('_security_main', serialize($token));

        //return new RedirectResponse($this->generateUrl("homepage"));
        return $this->redirectToRoute('homepage');
    }
}
