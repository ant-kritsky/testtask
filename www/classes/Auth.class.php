<?php
session_start(); //Запускаем сессии

/**
 * Класс для авторизации
 * @author Anton Kritsky <admin@delca.ru>
 */
class Auth
{
    private $_doAuthLimit = 5; //Максимальное количество неудачных попыток авторизаций
    private $_user = null; //Модель пользователей

    public function __construct()
    {
        $this->_user = new User();
    }

    /**
     * Проверяет, авторизован пользователь или нет
     * Возвращает true если авторизован, иначе false
     * @return boolean
     */
    public function isAuth()
    {
        if (isset($_SESSION["is_auth"])) { //Если сессия существует
            return $_SESSION["is_auth"]; //Возвращаем значение переменной сессии is_auth (хранит true если авторизован, false если не авторизован)
        } else return false; //Пользователь не авторизован, т.к. переменная is_auth не создана
    }

    /**
     * Попытка авторизации пользователя
     * @param string $login
     * @param string $passwors
     * @return boolean
     */
    public function doAuth($login, $passwors)
    {
        // Защита от попыток взлома
        // TODO: Можно подключить каптчу, но решил обойтись без сторонних библиотек
        if(empty($_SESSION["doAuth"]))
            $_SESSION["doAuth"] = 1;
        elseif($_SESSION["doAuth"] > $this->_doAuthLimit){
            echo _('detected hacking attempt!');die;
        } else $_SESSION["doAuth"] += 1;


        if ($user = $this->_user->getByLoginAndPass($login, $passwors)) { //Если есть пользователь с этим логином и паролем
            $_SESSION["is_auth"] = true; //Делаем пользователя авторизованным
            $_SESSION["login"] = $login; //Записываем в сессию логин пользователя
            $_SESSION["hash"] = $this->generateCode(); //Записываем в сессию хэш
            $_SESSION["doAuth"] = 0;
            $user->updateHash($_SESSION["hash"]);
            return true;
        } else { //Логин или пароль не подошел
            $_SESSION["is_auth"] = false;
            $_SESSION["error"] = _('Not valid login or password');
            return false;
        }
    }

    /**
     * Возвращает логин пользователя
     * @return string|null
     */
    public function getUser()
    {
        if ($this->isAuth()) { //Если пользователь авторизован
            return $this->_user->getByHash($_SESSION["hash"]);
        }
        return null;
    }

    /**
     * Возвращает хэш пользователя
     * @return string|null
     */
    public function getHash()
    {
        if ($this->isAuth()) { //Если пользователь авторизован
            return $_SESSION["hash"];
        }
        return null;
    }

    /**
     * Генерирует случайную строку для хэша
     * @param $length - какой длины строку генерировать
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
     * Разавторизация пользователя
     */
    public function out()
    {
        $_SESSION = array(); //Очищаем сессию
        session_destroy(); //Уничтожаем
    }
}