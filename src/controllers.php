<?php
/**
 * Routing and controllers.
 */

use Controller\IndexController;
use Controller\SignUpController;
use Controller\LogInController;
use Controller\AuthController;
use Controller\UserController;
use Controller\ProjectController;
use Controller\AdminController;
use Controller\GroupController;
use Controller\SubmissionController;

$app->mount('/', new IndexController());
$app->mount('/signup', new SignUpController());
$app->mount('/auth', new AuthController());
$app->mount('/user', new UserController());
$app->mount('/project', new ProjectController());
$app->mount('/admin', new AdminController());
$app->mount('/group', new GroupController());
$app->mount('/submission', new SubmissionController());
