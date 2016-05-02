<?php

// ini_set('error_reporting', E_ALL);
// ini_set('display_errors', true);

require_once dirname(dirname(__FILE__)) . '/vendor/autoload.php';

use Leafo\ScssPhp\Server;

$directory = '../src/assets/stylesheets';
Server::serveFrom($directory);
