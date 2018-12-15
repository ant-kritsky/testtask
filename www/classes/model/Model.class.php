<?php
/**
 * Базовый клас модели
 * @author Anton Kritsky <admin@delca.ru>
 */
class Model
{
    protected $_db = null;
    protected $_table = null;

    public function __construct()
    {
        $this->_db = Core::getInstance()->getDb();
        return $this;
    }

    public function delete($id)
    {
        $query = $this->_db->prepare("DELETE FROM `{$this->_table}` WHERE `id` = :id");
        $query->bindParam(":id", $id, PDO::PARAM_INT, $id);

        return $query->execute();
    }

    public function get($id = 0)
    {
        $query = $this->_db->prepare("SELECT {$this->_table}.* FROM {$this->_table} WHERE id=:id");
        $query->bindParam(":id", $id, PDO::PARAM_INT, 11);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function getAll()
    {
        $query = $this->_db->prepare("SELECT {$this->_table}.* FROM {$this->_table}");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

}