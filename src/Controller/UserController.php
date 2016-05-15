<?php

namespace Controller;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;

class UserController implements ControllerProviderInterface
{
  public function connect(Application $app)
  {
    $userController = $app['controllers_factory'];
    $userController->get('/', array($this, 'indexAction'))
      ->bind('user');
    return $userController;
  }

  public function indexAction(Application $app, Request $request)
  {
    return $app['twig']->render('User/index.html.twig');
  }
}
