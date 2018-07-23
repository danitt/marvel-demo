<?php

namespace AppBundle\Service;

use GuzzleHttp\Client;

class MarvelService
{

    private $client;
    private $baseQuery;

    public function __construct($marvel_private_key, $marvel_public_key){
        $ts = time();
        $hash = md5($ts . $marvel_private_key . $marvel_public_key);
        $this->baseQuery = [
          'apikey' => $marvel_public_key,
          'ts' => $ts,
          'hash' => $hash,
        ];
        $this->client = new Client([
            'base_uri' => 'http://gateway.marvel.com/v1/public/',
        ]);
    }

    private function get($path, $params = []) {
      $response = $this->client->get($path, [
          'query' => array_merge($this->baseQuery, $params),
      ]);
      $responseBody = json_decode($response->getBody(), true);
      return $responseBody;
    }
  
    public function listCharacters() {
      $response = $this->get('characters', [ 'limit' => 20 ]);
      return $response['data']['results'];
    }

    public function showCharacter($characterId) {
      $response = $this->get('characters/'.$characterId);
      return $response['data']['results'][0];
    }

}