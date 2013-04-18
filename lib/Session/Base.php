<?php

class Session_Base {
    
    public function __construct()
    {
        session_start();
    }
    
    public function __get($name)
    {
        return $_SESSION[$name];
    }
    
    public function __set($name, $value)
    {
        $_SESSION[$name] = $value;
    }
    
    public function authenticate()
    {
        $_SESSION['AUTHENTICATED'] = true;
    }
    
    public function isAuthenticated()
    {
        return (array_key_exists('AUTHENTICATED', $_SESSION)) ? $_SESSION['AUTHENTICATED'] : false;
    }
    
    public function deauthentication()
    {
        unset($_SESSION['AUTHENTICATED']);
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