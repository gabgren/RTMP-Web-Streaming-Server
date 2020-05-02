<?php
error_reporting(E_ALL);
ini_set('display_errors',1);

require('config.php');

session_start();

require(__DIR__ . '/vendor/autoload.php');

$db_sessions = new \Filebase\Database([
    'dir' => __DIR__ . '/db/sessions/'
]);