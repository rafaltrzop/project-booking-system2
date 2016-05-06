<?php

use Controller\IndexController;
use Controller\SignUpController;
use Controller\LogInController;

use Controller\HelloController;
use Controller\TasksController;
use Controller\TagsController;

$app->mount('/', new IndexController());
$app->mount('/signup', new SignUpController());
$app->mount('/login', new LogInController());

$app->mount('/hello', new HelloController());
$app->mount('/tasks', new TasksController());
$app->mount('/tags', new TagsController());
