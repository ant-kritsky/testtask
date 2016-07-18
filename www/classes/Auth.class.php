<?php
session_start(); //��������� ������

/**
 * ����� ��� �����������
 * @author Anton Kritsky <admin@delca.ru>
 */
class Auth
{
    private $_doAuthLimit = 5; //������������ ���������� ��������� ������� �����������
    private $_user = null; //������ �������������

    public function __construct()
    {
        $this->_user = new User();
    }

    /**
     * ���������, ����������� ������������ ��� ���
     * ���������� true ���� �����������, ����� false
     * @return boolean
     */
    public function isAuth()
    {
        if (isset($_SESSION["is_auth"])) { //���� ������ ����������
            return $_SESSION["is_auth"]; //���������� �������� ���������� ������ is_auth (������ true ���� �����������, false ���� �� �����������)
        } else return false; //������������ �� �����������, �.�. ���������� is_auth �� �������
    }

    /**
     * ������� ����������� ������������
     * @param string $login
     * @param string $passwors
     * @return boolean
     */
    public function doAuth($login, $passwors)
    {
        // ������ �� ������� ������
        // TODO: ����� ���������� ������, �� ����� �������� ��� ��������� ���������
        if(empty($_SESSION["doAuth"]))
            $_SESSION["doAuth"] = 1;
        elseif($_SESSION["doAuth"] > $this->_doAuthLimit){
            echo _('detected hacking attempt!');die;
        } else $_SESSION["doAuth"] += 1;


        if ($user = $this->_user->getByLoginAndPass($login, $passwors)) { //���� ���� ������������ � ���� ������� � �������
            $_SESSION["is_auth"] = true; //������ ������������ ��������������
            $_SESSION["login"] = $login; //���������� � ������ ����� ������������
            $_SESSION["hash"] = $this->generateCode(); //���������� � ������ ���
            $_SESSION["doAuth"] = 0;
            $user->updateHash($_SESSION["hash"]);
            return true;
        } else { //����� ��� ������ �� �������
            $_SESSION["is_auth"] = false;
            $_SESSION["error"] = _('Not valid login or password');
            return false;
        }
    }

    /**
     * ���������� ����� ������������
     * @return string|null
     */
    public function getUser()
    {
        if ($this->isAuth()) { //���� ������������ �����������
            return $this->_user->getByHash($_SESSION["hash"]);
        }
        return null;
    }

    /**
     * ���������� ��� ������������
     * @return string|null
     */
    public function getHash()
    {
        if ($this->isAuth()) { //���� ������������ �����������
            return $_SESSION["hash"];
        }
        return null;
    }

    /**
     * ���������� ��������� ������ ��� ����
     * @param $length - ����� ����� ������ ������������
     * @return string
     */
    function generateCode($length = 32)
    {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPRQSTUVWXYZ0123456789";
        $code = "";

        $clen = strlen($chars) - 1;
        while (strlen($code) < $length) {
            $code .= $chars[mt_rand(0, $clen)];
        }

        return $code;
    }

    /**
     * �������������� ������������
     */
    public function out()
    {
        $_SESSION = array(); //������� ������
        session_destroy(); //����������
    }
}