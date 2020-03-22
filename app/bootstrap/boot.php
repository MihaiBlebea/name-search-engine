<?php 

require_once __DIR__ . '/../vendor/autoload.php';

use App\Infrastructure\Container;
use App\Application\SearchService;
use App\Application\SearchResponse;
use App\Infrastructure\Mysql\Context;
use App\Infrastructure\Mysql\NameRepository;
use App\Infrastructure\Redis\Context as RedisContext;
use App\Infrastructure\Redis\SearchRepository;


$container = new Container();


$container->register('MysqlContext', function() {
    // return new Context("db", "admin", "pass");
    return new Context(getenv('MYSQL_HOST'), getenv('MYSQL_USERNAME'), getenv('MYSQL_PASSWORD'));
});

$container->register('NameRepository', function() use ($container) {
    return new NameRepository($container->get('MysqlContext'));
});

$container->register('RedisContext', function() {
    return new RedisContext(getenv('REDIS_HOST'));
});

$container->register('SearchRepository', function() use ($container) {
    return new SearchRepository($container->get('RedisContext'));
});

$container->register('SearchResponse', function() {
    return new SearchResponse();
});

$container->register('SearchService', function() use ($container) {
    return new SearchService(
        $container->get('NameRepository'), 
        $container->get('SearchRepository'),
        $container->get('SearchResponse')
    );
});

