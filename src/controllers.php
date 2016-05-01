<?php
/**
 * Routing and controllers.
 *
 * @copyright (c) 2016 Tomasz Chojna
 * @link http://epi.chojna.info.pl
 */

use Controller\HelloController;
use Controller\TasksController;
use Controller\TagsController;

$app->mount('/hello', new HelloController());
$app->mount('/tasks', new TasksController());
$app->mount('/tags', new TagsController());
