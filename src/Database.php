<?php

class Database
{
    protected string $dbname = 'app';
    protected string $host = 'database';
    protected string $user = 'app';
    protected string $password = 'app_password';
    protected PDO $connection;

    public function __construct()
    {
        $this->connection = new PDO(
            'mysql:dbname='.$this->dbname.';host='.$this->host,
            $this->user,
            $this->password
        );
    }

    public function getConnection(): PDO
    {
        return $this->connection;
    }
}