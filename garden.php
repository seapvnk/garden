<?php

$GARDEN_SCOPE = true;
require_once './config/config.php';

Loader::include('Garden');

Garden::expectArgs();
Garden::verifyListArgs();
Garden::performAction();
