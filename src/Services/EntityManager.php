<?php

class EntityManager
{
    public function __construct(
        protected PDO $connection
    ) {}
}
