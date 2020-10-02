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
        require_once CONTROLLER_PATH ."/{$controller}.php";
    }
}


