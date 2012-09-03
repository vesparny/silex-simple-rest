<?php

namespace Classes\Business;

use Vesparny\System\Database\AbstractBusinessService;

class Api extends AbstractBusinessService
{
    public function getTableName()
    {
        return 'prova';
    }

    public function getAll() {


        $sql = "SELECT * FROM prova";


        return $this->db->fetchAll($sql);
    }
}