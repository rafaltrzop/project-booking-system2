<?php
/**
 * Application front controller for production environment.
 */

ini_set('error_reporting', E_ALL);
ini_set('display_errors', false);

require_once dirname(__DIR__) . '/vendor/autoload.php';
$app = require_once dirname(__DIR__) . '/src/app.php';
require_once dirname(__DIR__) . '/src/controllers.php';

$app->run();
