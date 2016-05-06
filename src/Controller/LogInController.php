<?php

namespace Controller;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;

class LogInController implements ControllerProviderInterface
{
  public function connect(Application $app)
  {
    $logInController = $app['controllers_factory'];
    $logInController->get('/', array($this, 'indexAction'))
      ->bind('login');
    return $logInController;
  }

  public function indexAction(Application $app, Request $request)
  {
    return $app['twig']->render('LogIn/index.html.twig');
  }
}
