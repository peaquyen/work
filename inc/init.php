<?
// Session start
if (session_id() === '')
    session_start();

//Auto load class
spl_autoload_register(
    function ($className) {
        $dirRoot = dirname(__DIR__);
        $fileName = "classes/" . strtolower($className) . ".php";
        require $dirRoot . "/{$fileName}";
    }
);

require dirname(__DIR__) . "/config.php";
