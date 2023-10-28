<?php

namespace App\Helpers\GoogleBookApi;

use Exception;
use GuzzleHttp\Client;

class GoogleBookApiHelper
{

    const apiKey = 'AIzaSyAZdbexIcx2gYfFQSb1nwS-eFNvZwqznNs';
    public function getBook()
    {
        //$query = $params['q'];
        $client = new Client();
        $url = 'https://www.googleapis.com/books/v1/volumes?q=Harry potter&download=epub&key=' . self::apiKey;
        $url_1 = 'https://www.googleapis.com/books/v1/volumes?q=flowers+inauthor:keyes&key=' . self::apiKey;
        $url_2 = 'https://www.googleapis.com/books/v1/volumes?q=pride+prejudice&download=epub&key=' . self::apiKey;
        $url_3 = 'https://www.googleapis.com/books/v1/volumes?q=time&printType=magazines&key=' . self::apiKey;
        $url_4 = 'https://www.googleapis.com/books/v1/volumes?q=flowers&projection=full&key=' . self::apiKey;
        $url_5 = 'https://www.googleapis.com/books/v1/volumes/zyTCAlFPjgYC?key=' . self::apiKey;
        $url_6 = 'https://www.googleapis.com/books/v1/users/1112223334445556677/bookshelves&key=' . self::apiKey;

        try {
            $response = $client->request('GET', $url_6);
            $statusCode = $response->getStatusCode();
            $data = $response->getBody()->getContents();


            $bookData = json_decode($data);
            dd($bookData);
        } catch (Exception $e) {
            return 'Hata: ' . $e->getMessage();
        }
    }
}
