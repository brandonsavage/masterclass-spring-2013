<?php
/**
 * Created by JetBrains PhpStorm.
 * User: ricardo
 * Date: 4/18/13
 * Time: 5:11 PM
 * To change this template use File | Settings | File Templates.
 */

class Session_Php implements Session_Interface {


    public function __construct() {
        session_start();
    }

    public function get($name)
    {
        return $_SESSION[$name];
    }

    public function set($name,$value)
    {
        $_SESSION[$name]=$value;
    }

    public function regenerate()
    {
        session_regenerate_id();
    }

    public function destroy()
    {
        unset($_SESSION);
        session_destroy();
    }
}