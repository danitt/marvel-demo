<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\Favourite;
use AppBundle\Service\MarvelService;

class CharacterController extends Controller
{
    public function __construct(MarvelService $marvelService) {
      $this->marvelService = $marvelService;
    }

  /**
   * @Route("/characters", name="characters")
   */
    public function indexAction()
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $characters = $this->marvelService->listCharacters();
        return $this->render('character/index.html.twig', [
            'characters' => $characters,
        ]);
    }

  /**
   * @Route("/characters/{id}", name="charactersShow")
   */
    public function showAction($id, Request $request)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $characterInfo = $this->marvelService->showCharacter($id);
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $favouriteStatus = $em->getRepository(Favourite::class)
          ->getFavourites($user->getId(), $id)
          ->getResult();
        $isFavourite = $favouriteStatus && count($favouriteStatus);
        $comicNames = array_map(function($comic) {
          return $comic['name'];
        }, $characterInfo['comics']['items']);
        return $this->render('character/show.html.twig', [
          'character' => $characterInfo,
          'comicNames' => $comicNames,
          'isFavourite' => $isFavourite,
        ]);
    }

}
