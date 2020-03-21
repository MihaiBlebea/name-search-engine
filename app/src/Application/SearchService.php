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

    public function execute(String $terms, $dupes = false)
    {
        $collection = $this->searchRepo->search($terms);
        if($collection->isNotEmpty() === false)
        {
            $collection = $this->nameRepo->findByName($terms);
            if($collection->isNotEmpty() === false)
            {
                return [];
            }

            $collection->sort();
            $this->searchRepo->save($terms, $collection);
        }

        if($dupes === false)
        {
            $collection->removeDupes();
        }

        return $this->response->format($collection);
    }
}