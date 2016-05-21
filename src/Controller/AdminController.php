<?php

namespace Controller;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;

class AdminController implements ControllerProviderInterface
{
  public function connect(Application $app)
  {
    $userController = $app['controllers_factory'];
    $userController->get('/', array($this, 'indexAction'))
      ->bind('admin');
    return $userController;
  }

  public function indexAction(Application $app, Request $request)
  {
    $view = array();
    return $app['twig']->render('Admin/index.html.twig', $view);
  }
}
