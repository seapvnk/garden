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
        if (substr($name, 0, 2) == 'u_') {
            // unset
            $variable = str_replace('u_', '',  $name);
            self::stateRemove($variable);

        } else {

            if (!isset($arguments) || count($arguments) == 0) {
                return (self::state())->$name;
            } elseif (count($arguments) == 1) {
                (self::state())->$name = $arguments[0];
            } else {
                (self::state())->$name = $arguments;
            }

        }

    }
    
    public static function state()
    {
        if (!isset($_SESSION)) session_start();
        return new Session($_SESSION);
    }
    
    private static function stateRemove($state)
    {
        self::state()->$state = null;
        unset($_SESSION["u_$state"]);
    }
    
    public function __set($name, $value) 
    {
        if (is_object($value)) {
            $_SESSION[$name] = serialize($value);
        } else {
            $_SESSION[$name] = $value;
        }

    }
 
    public function __get($name) 
    {
        if ($_SESSION && isset($_SESSION[$name])) {
            $item = $_SESSION[$name]?? null;
            $output = $_SESSION[$name];
            $unserializedOuput = @unserialize($output);
    
            if (is_object($unserializedOuput)) {
                return $unserializedOuput;
            }
            
            return $output;
        }
        return null;
    }

}
