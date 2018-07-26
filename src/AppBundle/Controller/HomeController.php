<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\Favourite;

class HomeController extends Controller
{
    public function indexAction(Request $request)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $favourites = $em->getRepository(Favourite::class)->getFavourites($user->getId());
        return $this->render('home.html.twig', [
          'username' => $user->getUsername(),
          'favourites' => $favourites,
        ]);
    }
}
