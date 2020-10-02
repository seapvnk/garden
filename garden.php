<?php

require_once './config/config.php';

Loader::include('GardenIO');

GardenIO::print('Undefined something at line '. __LINE__, G_ERROR);
GardenIO::print('Take care of line '. __LINE__, G_WARNING);
GardenIO::print('Seeds created!', G_SUCCESS);
GardenIO::print('Usage: php garden.php seed Users', G_INFO);
