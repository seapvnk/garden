<?php

class Loader
{

    public static function include($name, $mode = null)
    {
        /**
         * Usage:
         *  Loader::include( <mode>, <name>)
         *  mode:
         *      Model: for including models
         *      Controller: for including controllers
         *  name: Resource's physical name
         */

        if (strtoupper($mode) === 'MODEL') {
            self::model($name);
        } elseif (strtoupper($mode) === 'CONTROLLER') {
            self::controller($name);
        } else {
            try {
                require_once CORE_PATH . "/{$name}.php";
            } catch (Exception $e) {
                throw new Exception(
                    'Missing resource type. usage: Loader::include(<Model/Controller>, <Name>)');
            }
        }
    }

    public static function view($name)
    {
        $path = VIEW_PATH . "/{$name}.php";
        if (!is_file($path)) return false;

        // Load g_vars from globals
        foreach ($GLOBALS as $key => $val) {
            if (substr($key, 0, 3) === 'gv_') {
                ${str_replace('gv_', '', $key)} = $val;
            }
        }

        require_once $path;

    }

    public static function template($name)
    {
        $name = trim($name);
        $path = VIEW_PATH . "/{$name}.garden.php";
        if (!is_file($path)) {
            echo "  <div style=\"width: 70vw ; margin: auto; padding: 1rem; color: white; background: tomato;\"> 
                        oops: View $name doesn't exists
                    </div>";
            exit;
        } else {
            return $path;
        }
    }

    // Private methods
    private static function model($name)
    {
        /**
         * Include a model
         */
        require_once MODEL_PATH . "/{$name}.php";
    }
    
    private static function controller($name)
    {
        /**
         * Include a controller
         */
        require_once CONTROLLER_PATH ."/{$name}.php";
    }

}


