<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\Favourite;

class FavouriteController extends Controller
{
    public function addAction(Request $request)
    {
        $characterId = $request->request->get('characterId');
        $userId = $this->getUser()->getId();
        $em = $this->getDoctrine()->getManager();
        $result = $em->getRepository(Favourite::class)
          ->addFavourite($userId, $characterId);
        return $this->json([
          'success' => $result,
          'characterId' => $characterId,
        ]);
    }

    public function removeAction(Request $request)
    {
        $characterId = $request->request->get('characterId');
        $userId = $this->getUser()->getId();
        $em = $this->getDoctrine()->getManager();
        $result = $em->getRepository(Favourite::class)
          ->removeFavourite($userId, $characterId);
        return $this->json([
          'success' => $result,
          'characterId' => $characterId,
        ]);
    }
}
