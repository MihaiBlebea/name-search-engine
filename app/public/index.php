<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../bootstrap/boot.php';

$app = AppFactory::create();


$app->get('/healthcheck', function (Request $request, Response $response, $args) {
    $response->withHeader('Content-type', 'application/json');
    $body = $response->getBody();

    $body->write(json_encode([
        "status" => "OK"
    ]));
    return $response;
});

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

$app->get('/search', function(Request $request, Response $response, $args) use ($container) {
    
    $response->withHeader('Content-type', 'application/json');
    $body = $response->getBody();

    $results = [];
    if(isset($_GET['terms']) && $_GET['terms'] !== "" && $_GET['terms'] !== " ")
    {
        $terms = $_GET['terms'];
        $dupes = isset($_GET['dupes']) && $_GET['dupes'] === 'true' ? true : false;

        $service = $container->get('SearchService');
        $results = $service->execute($terms, $dupes);
    }

    $body->write(json_encode($results));
    return $response;
});

$app->run();