<?php

namespace App\Model;

use MysqliDb;

class Db
{
    private string $host = 'mariadb';
    private string $user = 'root';
    private string $pass = '123456';
    private string $dbname = 'rest2';

    public function connect(): MysqliDb
    {
        return new MysqliDb ($this->host, $this->user, $this->pass, $this->dbname);
    }
}