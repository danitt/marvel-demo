<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class FavouriteController extends Controller
{
    public function addAction(Request $request)
    {
        $characterId = $request->request->get('characterId');
        return $this->json([
          'success' => true,
          'characterId' => $characterId,
        ]);
    }
}
