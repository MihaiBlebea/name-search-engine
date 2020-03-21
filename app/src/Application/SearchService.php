<?php 

namespace App\Application;

use App\Infrastructure\Mysql\NameRepository;
use App\Infrastructure\Redis\SearchRepository;


class SearchService
{
    private $nameRepo;

    private $searchRepo;

    private $response;

    public function __construct(NameRepository $nameRepo, SearchRepository $searchRepo, SearchResponse $response)
    {
        $this->nameRepo = $nameRepo;
        $this->searchRepo = $searchRepo;
        $this->response = $response;
    }

    public function execute(String $terms)
    {
        $cached = $this->searchRepo->search($terms);
        if(count($cached) > 0)
        {
            var_dump($cached);
            // die();
            return $cached;
        }

        $collection = $this->nameRepo->findByName($terms);

        if($collection->isNotEmpty() === false)
        {
            return [];
        }

        $collection->sort();

        $names = $this->response->format($collection);
        $this->searchRepo->save($terms, $names);

        return $names;
    }
}