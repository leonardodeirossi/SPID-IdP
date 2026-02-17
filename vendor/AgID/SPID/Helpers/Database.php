<?php

namespace AgID\SPID\Helpers;

use mysqli;
use mysqli_result;

class Database
{
    private mysqli $connection;
    private Environment $env;

    public function __construct(Environment $env)
    {
        $this->env = $env;
        $this->initConnection();
    }

    private function initConnection(): void
    {
        $this->connection = mysqli_connect("localhost", "aanmelden", "", "my_aanmelden");
    }

    public function getConnection(): mysqli
    {
        return $this->connection;
    }

    public function executeQuery(string $query): mysqli_result|bool
    {
        return mysqli_query(
            $this->connection,
            $query
        );
    }
}
