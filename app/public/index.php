<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

use App\Application\SearchService;
use App\Application\SearchResponse;
use App\Infrastructure\Mysql\Context;
use App\Infrastructure\Mysql\NameRepository;
use App\Infrastructure\Redis\Context as RedisContext;
use App\Infrastructure\Redis\SearchRepository;


require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();


$app->get('/', function (Request $request, Response $response, $args) {
    $file = 'index.html';
    
    if(file_exists($file)) 
    {
        $body = $response->getBody();
        $body->write(file_get_contents($file));
        return $response;
    } else {
        throw new \Slim\Exception\NotFoundException($request, $response);
    }
});

$app->get('/search', function(Request $request, Response $response, $args) {
    
    $response->withHeader('Content-type', 'application/json');
    $body = $response->getBody();

    $results = [];
    if(isset($_GET['terms']) && $_GET['terms'] !== "" && $_GET['terms'] !== " ")
    {
        $terms = $_GET['terms'];

        if(isset($_GET['dupes']) && $_GET['dupes'] === 'true')
        {
            $dupes = true;
        } else {
            $dupes = false;
        }

        $context = new Context("db", "admin", "pass");
        $nameRepository = new NameRepository($context);

        $redis = new RedisContext('redis');
        $searchRepository = new SearchRepository($redis);

        $service = new SearchService($nameRepository, $searchRepository, new SearchResponse());
        
        $results = $service->execute($terms, $dupes);
    }

    $body->write(json_encode($results));
    return $response;
});

$app->run();