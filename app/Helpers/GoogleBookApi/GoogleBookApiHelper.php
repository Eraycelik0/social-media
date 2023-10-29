<?php

namespace App\Helpers\GoogleBookApi;

use App\Models\Book;
use Exception;
use GuzzleHttp\Client;

class GoogleBookApiHelper
{

    public function getBook()
    {
        //$query = $params['q'];
        $client = new Client();
        $url = 'https://www.googleapis.com/books/v1/volumes?q=Harry potter&download=epub&key=' . env('GOOGLE_BOOKS_API_KEY');
        $url_1 = 'https://www.googleapis.com/books/v1/volumes?q=flowers+inauthor:keyes&key=' . env('GOOGLE_BOOKS_API_KEY');
        $url_2 = 'https://www.googleapis.com/books/v1/volumes?q=pride+prejudice&download=epub&key=' . env('GOOGLE_BOOKS_API_KEY');
        $url_3 = 'https://www.googleapis.com/books/v1/volumes?q=time&printType=magazines&key=' . env('GOOGLE_BOOKS_API_KEY');
        $url_4 = 'https://www.googleapis.com/books/v1/volumes?q=flowers&projection=full&key=' . env('GOOGLE_BOOKS_API_KEY');
        $url_5 = 'https://www.googleapis.com/books/v1/volumes/zyTCAlFPjgYC?key=' . env('GOOGLE_BOOKS_API_KEY');
        $url_6 = 'https://www.googleapis.com/books/v1/users/1112223334445556677/bookshelves&key=' . env('GOOGLE_BOOKS_API_KEY');

        try {
            $response = $client->request('GET', $url);
            $statusCode = $response->getStatusCode();
            $data = $response->getBody()->getContents();
            $bookData = json_decode($data);
        } catch (Exception $e) {
            return 'Hata: ' . $e->getMessage();
        }
    }

    public function getBooks_v1()
    {
        $client = new Client();
        $totalResults = 0;
        $maxResults = 40;

        while ($totalResults < 1000) {
            $startIndex = $totalResults;
            $url = 'https://www.googleapis.com/books/v1/volumes?q=your_search_query&maxResults=' . $maxResults . '&startIndex=' . $startIndex . '&key=' . env('GOOGLE_BOOKS_API_KEY');

            try {
                $response = $client->request('GET', $url);
                $statusCode = $response->getStatusCode();
                $data = $response->getBody()->getContents();
                $bookData = json_decode($data);
                $this->saveBooksToDatabase_v1($bookData);

                $totalResults += count($bookData->items);
            } catch (Exception $e) {
                return 'Hata: ' . $e->getMessage();
            }
        }
    }

    public function saveBooksToDatabase_v1($bookData)
    {
        try {
            if (isset($bookData->items)) {
                foreach ($bookData->items as $item) {
                    $book = new Book();
                    $book->title = isset($item->volumeInfo->title) ? $item->volumeInfo->title : null;
                    $book->description = isset($item->volumeInfo->description) ? $item->volumeInfo->description : null;
                    $book->authors = isset($item->volumeInfo->authors) ? implode(', ', $item->volumeInfo->authors) : null;
                    $book->pageCount = isset($item->volumeInfo->pageCount) ? $item->volumeInfo->pageCount : null;
                    $book->publisher = isset($item->volumeInfo->publisher) ? $item->volumeInfo->publisher : null;
                    $book->printType = isset($item->volumeInfo->printType) ? $item->volumeInfo->printType : null;
                    $book->imageLinks = isset($item->volumeInfo->imageLinks) ? json_encode($item->volumeInfo->imageLinks) : null;
                    $book->language = isset($item->volumeInfo->language) ? $item->volumeInfo->language : null;
                    $book->published_date = isset($item->volumeInfo->publishedDate) ? date('Y-m-d', strtotime($item->volumeInfo->publishedDate)) : null;

                    $book->save();
                }
            } else {
                return 'API yanıtında "items" özelliği bulunamadı.';
            }
            return 'Kitaplar veritabanına kaydedildi.';
        } catch (\Exception $e) {
            return 'Hata: ' . $e->getMessage();
        }
    }

}
