<?php

use Controller\IndexController;
use Controller\SignUpController;
use Controller\LogInController;
use Controller\AuthController;

$app->mount('/', new IndexController());
$app->mount('/signup', new SignUpController());
$app->mount('/auth', new Controller\AuthController());
