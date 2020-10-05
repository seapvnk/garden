<?php

class Session {


    private function __construct()
    {
        foreach ($_SESSION as $attribute => $value) {
           $this->$attribute = $value;
        }
        
    }

    public static function __callStatic($name, $arguments)
    {
        if (stripos('unset', $name) === 0) {
            $variable = str_replace('unset', '',  $name);
            self::stateRemove($variable);
        } else {
            if (!isset($arguments) || count($arguments) === 0) {
                return (self::state())->$name;
            } elseif (count($arguments) === 1) {
                (self::state())->$name = $arguments[0];
            } else {
                (self::state())->$name = $arguments;
            }
        }
    }

    private static function state()
    {
        return new Session($_SESSION);
    }

    private static function stateRemove($state)
    {
        self::state()->$state = null;
    }

    public function __set($name, $value) 
    {
        $_SESSION[$name] = serialize($value);
    }
 
    public function __get($name) 
    {
        $item = $_SESSION[$name]?? null;
        return unserialize($item);
    }

}