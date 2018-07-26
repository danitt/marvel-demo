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
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $userFavourites = $em->getRepository(Favourite::class)
        ->getFavourites($user->getId())
        ->getResult();
        $favourites = [];
        foreach($userFavourites as $fav) {
          $character = $this->marvelService->showCharacter($fav->characterId);
          array_push($favourites, $character);
        }
        return $this->render('favourite.html.twig', [
          'favourites' => $favourites,
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
