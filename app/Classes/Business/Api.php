<?php

namespace Classes\Business;

use Vesparny\System\Database\AbstractBusinessService;

class Api extends AbstractBusinessService
{
	public function getTableName()
	{
		return 'hello';
	}

	public function getAll() {
		$sql = "SELECT * FROM hello";
		return $this->db->fetchAll($sql);
	}
}