<?php

namespace App\Services;

class BaseService extends \App\BaseRestApi
{

    /**
     * This is the equivalent table Name in the database
     *
     * @var string
     */
    public $modelName;

    /**
     * BaseService constructor.
     *
     * @param Application $api
     */
    public function __construct($api)
    {
        parent::__construct($api);

        $this->getServiceName();
    }

    /**
     * Formats the given class name to an api endpoint name.
     *
     * @return string
     */
    public function getServiceName()
    {

        $class = new \ReflectionClass(get_class($this));

        if (isset($this->serviceModel)) {
            $this->modelName = $this->serviceModel;
        } else {
            $modelName = $class->getShortName();
            $this->modelName = str_replace("service", "", strtolower($modelName));
        }


        return $this->modelName;
    }

    /**
     * @return array
     */
    public function getAll()
    {
        return $this->db->fetchAll("SELECT * FROM $this->modelName");
    }

    /**
     * Save a company
     *
     * @param array $company
     * @return int
     */
    public function save($company)
    {
        $this->db->insert($this->modelName, $company);
        return $this->db->lastInsertId();
    }

    /**
     * @param int $id
     * @param array $company
     * @return mixed
     */
    public function update($id, $company)
    {
        return $this->db->update($this->modelName, $company, ['id' => $id]);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        return $this->db->delete($this->modelName, array("id" => $id));
    }


}
