<?php

/**
 * ������ ������������
 * @author Anton Kritsky <admin@delca.ru>
 */
class User extends Model
{
    public $id = null;
    public $name = null;
    public $email = null;
    public $created_at = null;

    protected $_table = 'users';

    /**
     * ���������� ������������
     */
    public function add($login = null, $password = null, $name = null, $ext = null)
    {
        $query = $this->_db->prepare("INSERT INTO {$this->_table}
            (`email`,`password`, `name`, `file_ext`) VALUES
            (:login, :password, :name, :ext)");

        $query->bindParam(":name", $name, PDO::PARAM_STR, 250);
        $query->bindParam(":login", $login, PDO::PARAM_STR, 150);
        $query->bindParam(":password", $password, PDO::PARAM_STR, 150);
        $query->bindParam(":ext", $ext, PDO::PARAM_STR, 10);
        $query->execute();
        return $this->_db->lastInsertId();
    }

    /**
     * ���������� ���� ������������
     */
    public function updateHash($hash = null)
    {
        if(mb_strlen($hash) < 3) return false;
        $query = $this->_db->prepare("UPDATE {$this->_table} SET `hash`=:hash WHERE id=:id");
        $query->bindParam(":id", $this->id, PDO::PARAM_INT, 11);
        $query->bindParam(":hash", $hash, PDO::PARAM_STR, 150);
        return $query->execute();
    }

    /**
     * ��������� ������������ �� ������ � ������
     * @return User
     */
    public function getByLoginAndPass($login = null, $password = null)
    {
        if($login == null or $password == null) return false;
        $query = $this->_db->prepare("SELECT * FROM {$this->_table} WHERE `email`=:login AND `password`=:password");
        $query->bindParam(":login", $login, PDO::PARAM_STR);
        $query->bindParam(":password", $password, PDO::PARAM_STR);
        $query->execute();
        $result = $query->fetchObject(__CLASS__);
        return $result;
    }

    /**
     * ��������� ������������ �� ����
     */
    public function getByHash($hash = null)
    {
        $query = $this->_db->prepare("SELECT * FROM {$this->_table} WHERE `hash`=:hash");
        $query->bindParam(":hash", $hash, PDO::PARAM_STR, 150);
        $query->execute();
        $result = $query->fetchObject(__CLASS__);
        return $result;
    }

}