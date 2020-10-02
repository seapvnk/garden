<?php

$GARDEN_SCOPE = true;
require_once './config/config.php';

Loader::include('GardenIO');

$options = [
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

if (GardenIO::inputCount() === 0) {
    echo GardenIO::print('garden require at least one arg... Try "php garden.php help"', G_INFO);
}

if (GardenIO::has('help') || GardenIO::has('list')) {
    if (GardenIO::has('help')) {
        $output = "Available commands";
    } else {
        $output = "List of commands";
    }

    $output .= GardenIO::EOL;

    foreach ($options as $option => $usage) {
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