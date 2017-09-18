<?php

namespace App\Services;

use Doctrine\DBAL\Connection;

class BaseService
{
    protected $db;

    public function __construct(Connection $db)
    {
        $this->db = $db;
    }
}
