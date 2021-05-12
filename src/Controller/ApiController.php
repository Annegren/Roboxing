<?php

namespace App\Controller;

use App\Model\ApiManager;

class ApiController extends AbstractController
{
    public function getNasaPic(): string
    {
        $apiManager = new ApiManager();
        $url = 'https://api.nasa.gov/mars-photos/api/v1/rovers/curiosity/photos?sol=1000&page=2&api_key=h9BqoCgdUaCZU8xcnqbGQQttxtHefLRDnZVxOT79';
        $response = $apiManager->getApi($url);

        foreach ($response as $photos) {
            $img = array_rand($photos, 1);
            $randImg = $photos[$img]['img_src'];
        }

        return $this->twig->render('Combat/add.html.twig', [
            'response' => $response, 'randImg' => $randImg
        ]);
    }
}
