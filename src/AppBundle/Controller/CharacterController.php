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
    public function indexAction()
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $characters = $this->marvelService->listCharacters();
        return $this->render('character/index.html.twig', [
            'characters' => $characters,
        ]);
    }

    public function showAction($id, Request $request)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        // $characterInfo = $this->marvelService->showCharacter($id);
        $characterInfo = unserialize($this->characterSample);
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $favouriteStatus = $em->getRepository(Favourite::class)
          ->getFavourites($user->getId(), $id)
          ->getResult();
        var_dump($favouriteStatus);
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

    private $characterSample = 'a:11:{s:2:"id";i:1011334;s:4:"name";s:7:"3-D Man";s:11:"description";s:0:"";s:8:"modified";s:24:"2014-04-29T14:18:17-0400";s:9:"thumbnail";a:2:{s:4:"path";s:57:"http://i.annihil.us/u/prod/marvel/i/mg/c/e0/535fecbbb9784";s:9:"extension";s:3:"jpg";}s:11:"resourceURI";s:54:"http://gateway.marvel.com/v1/public/characters/1011334";s:6:"comics";a:4:{s:9:"available";i:12;s:13:"collectionURI";s:61:"http://gateway.marvel.com/v1/public/characters/1011334/comics";s:5:"items";a:12:{i:0;a:2:{s:11:"resourceURI";s:48:"http://gateway.marvel.com/v1/public/comics/21366";s:4:"name";s:35:"Avengers: The Initiative (2007) #14";}i:1;a:2:{s:11:"resourceURI";s:48:"http://gateway.marvel.com/v1/public/comics/24571";s:4:"name";s:55:"Avengers: The Initiative (2007) #14 (SPOTLIGHT VARIANT)";}i:2;a:2:{s:11:"resourceURI";s:48:"http://gateway.marvel.com/v1/public/comics/21546";s:4:"name";s:35:"Avengers: The Initiative (2007) #15";}i:3;a:2:{s:11:"resourceURI";s:48:"http://gateway.marvel.com/v1/public/comics/21741";s:4:"name";s:35:"Avengers: The Initiative (2007) #16";}i:4;a:2:{s:11:"resourceURI";s:48:"http://gateway.marvel.com/v1/public/comics/21975";s:4:"name";s:35:"Avengers: The Initiative (2007) #17";}i:5;a:2:{s:11:"resourceURI";s:48:"http://gateway.marvel.com/v1/public/comics/22299";s:4:"name";s:35:"Avengers: The Initiative (2007) #18";}i:6;a:2:{s:11:"resourceURI";s:48:"http://gateway.marvel.com/v1/public/comics/22300";s:4:"name";s:52:"Avengers: The Initiative (2007) #18 (ZOMBIE VARIANT)";}i:7;a:2:{s:11:"resourceURI";s:48:"http://gateway.marvel.com/v1/public/comics/22506";s:4:"name";s:35:"Avengers: The Initiative (2007) #19";}i:8;a:2:{s:11:"resourceURI";s:47:"http://gateway.marvel.com/v1/public/comics/8500";s:4:"name";s:19:"Deadpool (1997) #44";}i:9;a:2:{s:11:"resourceURI";s:48:"http://gateway.marvel.com/v1/public/comics/10223";s:4:"name";s:26:"Marvel Premiere (1972) #35";}i:10;a:2:{s:11:"resourceURI";s:48:"http://gateway.marvel.com/v1/public/comics/10224";s:4:"name";s:26:"Marvel Premiere (1972) #36";}i:11;a:2:{s:11:"resourceURI";s:48:"http://gateway.marvel.com/v1/public/comics/10225";s:4:"name";s:26:"Marvel Premiere (1972) #37";}}s:8:"returned";i:12;}s:6:"series";a:4:{s:9:"available";i:3;s:13:"collectionURI";s:61:"http://gateway.marvel.com/v1/public/characters/1011334/series";s:5:"items";a:3:{i:0;a:2:{s:11:"resourceURI";s:47:"http://gateway.marvel.com/v1/public/series/1945";s:4:"name";s:38:"Avengers: The Initiative (2007 - 2010)";}i:1;a:2:{s:11:"resourceURI";s:47:"http://gateway.marvel.com/v1/public/series/2005";s:4:"name";s:22:"Deadpool (1997 - 2002)";}i:2;a:2:{s:11:"resourceURI";s:47:"http://gateway.marvel.com/v1/public/series/2045";s:4:"name";s:29:"Marvel Premiere (1972 - 1981)";}}s:8:"returned";i:3;}s:7:"stories";a:4:{s:9:"available";i:21;s:13:"collectionURI";s:62:"http://gateway.marvel.com/v1/public/characters/1011334/stories";s:5:"items";a:20:{i:0;a:3:{s:11:"resourceURI";s:49:"http://gateway.marvel.com/v1/public/stories/19947";s:4:"name";s:12:"Cover #19947";s:4:"type";s:5:"cover";}i:1;a:3:{s:11:"resourceURI";s:49:"http://gateway.marvel.com/v1/public/stories/19948";s:4:"name";s:12:"The 3-D Man!";s:4:"type";s:13:"interiorStory";}i:2;a:3:{s:11:"resourceURI";s:49:"http://gateway.marvel.com/v1/public/stories/19949";s:4:"name";s:12:"Cover #19949";s:4:"type";s:5:"cover";}i:3;a:3:{s:11:"resourceURI";s:49:"http://gateway.marvel.com/v1/public/stories/19950";s:4:"name";s:18:"The Devil\'s Music!";s:4:"type";s:13:"interiorStory";}i:4;a:3:{s:11:"resourceURI";s:49:"http://gateway.marvel.com/v1/public/stories/19951";s:4:"name";s:12:"Cover #19951";s:4:"type";s:5:"cover";}i:5;a:3:{s:11:"resourceURI";s:49:"http://gateway.marvel.com/v1/public/stories/19952";s:4:"name";s:29:"Code-Name:  The Cold Warrior!";s:4:"type";s:13:"interiorStory";}i:6;a:3:{s:11:"resourceURI";s:49:"http://gateway.marvel.com/v1/public/stories/47184";s:4:"name";s:35:"AVENGERS: THE INITIATIVE (2007) #14";s:4:"type";s:5:"cover";}i:7;a:3:{s:11:"resourceURI";s:49:"http://gateway.marvel.com/v1/public/stories/47185";s:4:"name";s:41:"Avengers: The Initiative (2007) #14 - Int";s:4:"type";s:13:"interiorStory";}i:8;a:3:{s:11:"resourceURI";s:49:"http://gateway.marvel.com/v1/public/stories/47498";s:4:"name";s:35:"AVENGERS: THE INITIATIVE (2007) #15";s:4:"type";s:5:"cover";}i:9;a:3:{s:11:"resourceURI";s:49:"http://gateway.marvel.com/v1/public/stories/47499";s:4:"name";s:41:"Avengers: The Initiative (2007) #15 - Int";s:4:"type";s:13:"interiorStory";}i:10;a:3:{s:11:"resourceURI";s:49:"http://gateway.marvel.com/v1/public/stories/47792";s:4:"name";s:35:"AVENGERS: THE INITIATIVE (2007) #16";s:4:"type";s:5:"cover";}i:11;a:3:{s:11:"resourceURI";s:49:"http://gateway.marvel.com/v1/public/stories/47793";s:4:"name";s:41:"Avengers: The Initiative (2007) #16 - Int";s:4:"type";s:13:"interiorStory";}i:12;a:3:{s:11:"resourceURI";s:49:"http://gateway.marvel.com/v1/public/stories/48361";s:4:"name";s:35:"AVENGERS: THE INITIATIVE (2007) #17";s:4:"type";s:5:"cover";}i:13;a:3:{s:11:"resourceURI";s:49:"http://gateway.marvel.com/v1/public/stories/48362";s:4:"name";s:41:"Avengers: The Initiative (2007) #17 - Int";s:4:"type";s:13:"interiorStory";}i:14;a:3:{s:11:"resourceURI";s:49:"http://gateway.marvel.com/v1/public/stories/49103";s:4:"name";s:35:"AVENGERS: THE INITIATIVE (2007) #18";s:4:"type";s:5:"cover";}i:15;a:3:{s:11:"resourceURI";s:49:"http://gateway.marvel.com/v1/public/stories/49104";s:4:"name";s:41:"Avengers: The Initiative (2007) #18 - Int";s:4:"type";s:13:"interiorStory";}i:16;a:3:{s:11:"resourceURI";s:49:"http://gateway.marvel.com/v1/public/stories/49106";s:4:"name";s:57:"Avengers: The Initiative (2007) #18, Zombie Variant - Int";s:4:"type";s:13:"interiorStory";}i:17;a:3:{s:11:"resourceURI";s:49:"http://gateway.marvel.com/v1/public/stories/49888";s:4:"name";s:35:"AVENGERS: THE INITIATIVE (2007) #19";s:4:"type";s:5:"cover";}i:18;a:3:{s:11:"resourceURI";s:49:"http://gateway.marvel.com/v1/public/stories/49889";s:4:"name";s:41:"Avengers: The Initiative (2007) #19 - Int";s:4:"type";s:13:"interiorStory";}i:19;a:3:{s:11:"resourceURI";s:49:"http://gateway.marvel.com/v1/public/stories/54371";s:4:"name";s:60:"Avengers: The Initiative (2007) #14, Spotlight Variant - Int";s:4:"type";s:13:"interiorStory";}}s:8:"returned";i:20;}s:6:"events";a:4:{s:9:"available";i:1;s:13:"collectionURI";s:61:"http://gateway.marvel.com/v1/public/characters/1011334/events";s:5:"items";a:1:{i:0;a:2:{s:11:"resourceURI";s:46:"http://gateway.marvel.com/v1/public/events/269";s:4:"name";s:15:"Secret Invasion";}}s:8:"returned";i:1;}s:4:"urls";a:3:{i:0;a:2:{s:4:"type";s:6:"detail";s:3:"url";s:115:"http://marvel.com/comics/characters/1011334/3-d_man?utm_campaign=apiRef&utm_source=5e81be6d83db385fc40897aa9436050d";}i:1;a:2:{s:4:"type";s:4:"wiki";s:3:"url";s:109:"http://marvel.com/universe/3-D_Man_(Chandler)?utm_campaign=apiRef&utm_source=5e81be6d83db385fc40897aa9436050d";}i:2;a:2:{s:4:"type";s:9:"comiclink";s:3:"url";s:115:"http://marvel.com/comics/characters/1011334/3-d_man?utm_campaign=apiRef&utm_source=5e81be6d83db385fc40897aa9436050d";}}}';
}
