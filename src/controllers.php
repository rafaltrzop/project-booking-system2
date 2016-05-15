<?php

use Controller\IndexController;
use Controller\SignUpController;
use Controller\LogInController;
use Controller\AuthController;
use Controller\UserController;

$app->mount('/', new IndexController());
$app->mount('/signup', new SignUpController());
$app->mount('/auth', new AuthController());
$app->mount('/user', new UserController());
