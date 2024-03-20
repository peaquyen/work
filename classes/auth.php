<?
class Auth
{
    //Create session after login
    public static function setSession($key, $value)
    {
        return $_SESSION[$key] = $value;
    }

    //Get info session
    public static function getSession($key = '')
    {
        if (empty($key))
            return $_SESSION;
        else {
            if (isset($_SESSION[$key]))
                return $_SESSION[$key];
        }
    }

    //Delete session after logout
    public static function deleteSession($key = '')
    {
        if (empty($key)) {
            session_destroy();
            return true;
        } else {
            if (isset($_SESSION[$key])) {
                unset($_SESSION[$key]);
                return true;
            }
        }
    }

    //Flash data
    public static function setFlashData($key, $value)
    {
        $key = "flash_" . $key;
        return self::setSession($key, $value);
    }

    public static function getFlashData($key = '')
    {
        $key = "flash_" . $key;
        $data = self::getSession($key);
        self::deleteSession($key);
        return $data;
    }

    //Check logged in
    public static function isLoggedIn()
    {
        $checkLogin = false;
        if (self::getSession('login')) {
            $tokenLogin =  self::getSession('login');

            $db = require "inc/db.php";

            $queryToken = $db->query('SELECT user_id FROM login WHERE token = :tokenLogin', ['tokenLogin' => $tokenLogin])->fetch(PDO::FETCH_ASSOC);

            if (!empty($queryToken))
                $checkLogin = true;
            else
                self::deleteSession('login');
        }

        return $checkLogin;
    }
}
