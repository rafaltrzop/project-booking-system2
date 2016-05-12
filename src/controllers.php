<?php

use Controller\IndexController;
use Controller\SignUpController;
use Controller\LogInController;

$app->mount('/', new IndexController());
$app->mount('/signup', new SignUpController());
$app->mount('/login', new LogInController());
