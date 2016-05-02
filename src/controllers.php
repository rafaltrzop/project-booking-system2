<?php

use Controller\IndexController;
use Controller\HelloController;
use Controller\TasksController;
use Controller\TagsController;

$app->mount('/', new IndexController());
$app->mount('/hello', new HelloController());
$app->mount('/tasks', new TasksController());
$app->mount('/tags', new TagsController());
