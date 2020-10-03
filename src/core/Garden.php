<?php

Loader::include('GardenIO');

class Garden
{
    private static $options = [
        'help/list' => 'show all commands',
        'model' => [
            '=delete' => 'delete a model',
            '=create' => 'create a model',
        ],
        'controller' => [
            '=delete' => 'delete a controller',
            '=create' => 'create a controller',
        ],
    ];


    public static function performAction()
    {
        $action = self::getValidOption();
        if (!$action)  {
            GardenIO::print(
            'Can\'t find a valid option. use flag list or help to see all available options', G_ERROR);
            exit();
        }

        $optionToAction = GardenIO::args($action);
        self::requireAdminPrivileges();

        if ($optionToAction == null || $optionToAction === 'create') {
            self::create($action);
        }
    }


    public static function expectArgs()
    {
        if (GardenIO::inputCount() === 0) {
            echo GardenIO::print('garden require at least one arg... Try "php garden.php help"', G_INFO);
            exit();
        }
    }

    public static function verifyListArgs()
    {
        if (GardenIO::has('help') || GardenIO::has('list')) {
            if (GardenIO::has('help')) {
                $output = "Available commands";
            } else {
                $output = "List of commands";
            }
        
            $output .= GardenIO::EOL;
        
            foreach (self::$options as $option => $usage) {
                if (is_array($usage)) {
                    $usageString = GardenIO::_TAB . "$option :" . GardenIO::EOL;
                    foreach ($usage as $opt => $description) {
                        $usageString .= str_repeat(GardenIO::_TAB, 2) . "{$opt} : {$description} " . GardenIO::EOL;
                    }
                    $usage = $usageString;
                    $output .= $usage;
                } else {
                    $output .= GardenIO::_TAB . "{$option} : {$usage}" . GardenIO::EOL;
                }
            }
        
            GardenIO::print($output, G_INFO);
        }
    }

    // Privates

    private static function create($type)
    {
        $obj = GardenIO::argNextTo($type);
        $params = GardenIO::getArgsThatStartsWith('.');
        
        $typeCapitalized = ucwords($type);

        if ($obj == false) {
            GardenIO::print("Please give a valid name to your $typeCapitalized.", G_WARNING);    
            exit();
        } elseif (file_exists(SRC_PATH . "/$type/{$obj}.php")) {
            GardenIO::print("$typeCapitalized '$obj' already exists.", G_WARNING);    
            exit();
        }
        
        GardenIO::print("$typeCapitalized '$obj' created successfully!", G_SUCCESS);

    }

    #private static function create

    private static function getValidOption()
    {
        // find the first creat/delete option
        foreach (array_keys(GardenIO::args()) as $option) {
            if (self::isAction($option)) return $option;
        }
        return false;
    }

    private static function isAction($option)
    {
        $canNotCreate = ['help/list'];
        foreach (self::$options as $key => $val) {
            if ($option == $key && !in_array($option, $canNotCreate))
                return true;
        }

        return false;
    }

    private static function requireAdminPrivileges()
    {
        if (!posix_getuid() == 0){
            GardenIO::print('This action requires admin privileges', G_ERROR);
            exit();
        }
    }
}