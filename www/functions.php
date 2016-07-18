<?php
function __autoload($className)
{
    $directorys = array(
        CLASSES_DIR,
        MODEL_DIR,
        CONTROPPERS_DIR
    );

    foreach ($directorys as $directory) {
        $path = $directory . $className . '.class.php';
        if (file_exists($path)) {
            require_once($path);
            return true;
        }
    }

    return false;
}