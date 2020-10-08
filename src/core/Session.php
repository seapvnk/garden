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
        if (stripos('u_', $name) == 0) {
            // unset
            $variable = str_replace('u_', '',  $name);
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
        if (!isset($_SESSION)) session_start();
        return new Session($_SESSION);
    }

    private static function stateRemove($state)
    {
        self::state()->$state = null;
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
        
        $item = $_SESSION[$name]?? null;
        $output = $_SESSION[$name];
        $unserializedOuput = @unserialize($output);

        if ($unserializedOuput) {
            return $unserializedOuput;
        }
        
        return $output;
    }

}
