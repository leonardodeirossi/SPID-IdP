<?php

namespace AgID\SPID\Helpers;

class Environment
{
    private Database $database;

    public function __construct()
    {
        $this->database = new Database($this);
    }

    public function getDatabase(): Database
    {
        return $this->database;
    }
}
