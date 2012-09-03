<?php

namespace Vesparny\System\Database;

use Doctrine\DBAL\Connection;

abstract class AbstractBusinessService
{
    abstract public function getTableName();

    public $db;

    public function __construct(Connection $db = null)
    {
        $this->db = $db;
    }

}