<?php

/**
 * Класс шаблонизатора
 * @author Anton Kritsky <admin@delca.ru>
 */
class View
{
    private $_path;
    private $_template;
    private $_var = [];

    public function __construct($path = '')
    {
        $this->_path = $path;
        $this->set("lang", Core::$lang);
    }

    /**
     * Сеттер переменных шаблона
     * @param ключ переменной
     * @param значение переменной
     */
    public function set($name, $value)
    {
        $this->_var[$name] = $value;
    }

    /**
     * Геттер переменных шаблона
     * @param ключ переменной
     */
    public function get($name)
    {
        if (isset($this->_var[$name])) return $this->_var[$name];
        return '';
    }

    /**
     * Возвращает пост параметр
     *
     * т.к. значение используется в значениях
     * элементов ворм - html теги экранируем
     *
     * @param ключ переменной
     */
    public function getPost($name)
    {
        if (isset($_POST[$name])) return htmlspecialchars($_POST[$name]);
        return '';
    }

    /**
     * Рендеринг шаблона
     * @param Имя шаблона
     * @param Использовать лайаут или нет
     */
    public function render($template, $layout = false)
    {
        global $locales;
        $this->_template = $this->_path . $template;
        if (!file_exists($this->_template)) die('Template ' . $this->_template . ' not exist!');

        ob_start();
        include($this->_template);
        $content = ob_get_clean();
        if ($layout) include($this->_path . "layout.php");
        else echo $content;
    }

}