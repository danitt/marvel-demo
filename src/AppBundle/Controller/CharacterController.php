<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Service\MarvelService;

class CharacterController extends Controller
{
  public function __construct(MarvelService $marvelService) {
    $this->marvelService = $marvelService;
  }
    public function indexAction()
    {
        $characters = $this->marvelService->listCharacters();
        return $this->render('character/index.html.twig', [
            'characters' => $characters,
        ]);
    }

    public function showAction($id, Request $request)
    {
        $characterInfo = $this->marvelService->showCharacter($id);
        var_dump($characterInfo);
        return $this->render('character/show.html.twig', [
          'character' => $characterInfo,
        ]);
    }
}
