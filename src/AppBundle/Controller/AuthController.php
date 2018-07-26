<?php

namespace AppBundle\Controller;

use AppBundle\Form\UserType;
use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AuthController extends Controller
{

  /**
   * @Route("/", name="login")
   * @Route("/logout", name="logout")
   */
    public function loginAction(Request $request, AuthenticationUtils $authenticationUtils)
    {
        $user = $this->getUser();
        if ($user) {
          return $this->redirectToRoute('home');
        }
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('auth/login.html.twig', [
            'last_username' => $lastUsername,
            'error'         => $error,
        ]);
    }

  /**
   * @Route("/register", name="register")
   */
    public function registerAction(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {

      if ($request->getMethod() === 'POST') {
          $errors = '';
          $username = $request->request->get('_username');
          $passwordPlain = $request->request->get('_password');

          $user = new User();

          $user->setUsername($username);
          $password = $passwordEncoder->encodePassword($user, $passwordPlain);
          $user->setPassword($password);

          $entityManager = $this->getDoctrine()->getManager();
          $entityManager->persist($user);
          $entityManager->flush();

          return $this->redirectToRoute('home');
      }

      return $this->render('auth/register.html.twig', [ 'errors' => [] ]);
    }

}
