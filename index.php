<?php
// error output for debugging reasons
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'bootstrap.php';
require_once 'routes.php';
// Run app
$app->run();
