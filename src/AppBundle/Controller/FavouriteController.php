<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\Favourite;
use AppBundle\Service\MarvelService;

class FavouriteController extends Controller
{

    public function __construct(MarvelService $marvelService) {
      $this->marvelService = $marvelService;
    }

  /**
   * @Route("/favourites", name="favourites")
   */
    public function indexAction()
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        // $characters = $this->marvelService->listCharacters();
        return $this->render('favourite.html.twig', [
            'favourites' => [],
        ]);
    }

  /**
   * @Route("/favourites/add", name="favouritesAdd")
   */
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

  /**
   * @Route("/favourites/remove", name="favouritesRemove")
   */
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
