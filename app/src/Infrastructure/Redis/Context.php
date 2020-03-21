<?php

namespace App\Infrastructure\Redis;

use Predis\Client;


class Context
{
    private $host;

    private $port;


    public function __construct(String $host, Int $port = 6379)
    {
        $this->host = $host;
        $this->port = $port;
    }

    public function connect()
    {
        try {
            $client = new Client([
                'scheme' => 'tcp',
                'host'   => $this->host,
                'port'   => $this->port,
            ]);
            return $client;
        } catch(Exception $e) {
            echo "Connection failed: " . $e->getMessage();
            return null;
        }
    }
}