<?php

namespace App\Model;

use MysqliDb;

class Db
{
    public function connect(): MysqliDb
    {
        return new MysqliDb ($_ENV['DB_HOST'], $_ENV['DB_USER'], $_ENV['DB_PASS'], $_ENV['DB_NAME']);
    }
}