<?php

namespace App\Infrastructure\Mysql;


class Context
{
    private $host;

    private $username;

    private $password;

    public function __construct(String $host, String $username, String $password)
    {
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
    }

    public function connect()
    {
        try {
            $conn = new \PDO("mysql:host=$this->host;dbname=db", $this->username, $this->password);
            $conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            return $conn;

        } catch(\PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
            return null;
        }
    }
}