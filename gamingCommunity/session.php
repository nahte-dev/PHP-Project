<?php

class Session
{
    function start()
    {
        session_start();
    }

    function get($key) 
    {
        if ($this->isKeySet($key))
        {
           return $_SESSION[$key];
        }
        else
        {
            return NULL;
        }
    }

    function set($key, $value) 
    {
        $_SESSION[$key] = $value;
    }

    function isKeySet($key) 
    {
        return isset($_SESSION[$key]);
    }

    function unsetKey($key)
    {
        unset($_SESSION[$key]);
    }

    function clear() 
    {
        foreach ($_SESSION as $key=>$value) 
        {
            unset($_SESSION[$key]);
        }
        session_destroy();
    }

}
