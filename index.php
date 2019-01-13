<?php
// error output for debugging reasons
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('bootstrap.php');
require_once('routes.php');
// Run app
$app->run();
/* $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING);
$db = new PDO('mysql:host=localhost;dbname=devjmckenzie_property', 'root', 'root', $options);
$output = $db->query('SELECT * FROM Property');
var_dump($output->fetchAll()); */