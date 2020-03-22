<?php 

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/bootstrap/boot.php';

use App\Infrastructure\Mysql\Context;


if(!function_exists('fetchCsvData')) 
{
    function fetchCsvData()
    {
        $result = array_map('str_getcsv', file('names.csv'));
        $result = array_map(function($value) {
            return preg_replace("/\s+/", " ", $value[0]);
        }, $result);

        return $result;
    }
}

if(!function_exists('createNamesTable')) 
{
    function createNamesTable(Context $context)
    {
        $conn = $context->connect();
        $sql = "CREATE TABLE IF NOT EXISTS names (
            id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(100) NOT NULL,
            updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            created TIMESTAMP DEFAULT CURRENT_TIMESTAMP)";

        $conn->exec($sql);
        $conn = null;
    }
}


$data = fetchCsvData();

createNamesTable($container->get('MysqlContext'));

$repository = $container->get('NameRepository');

$repository->seed($data);