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
    $userController->get('/add', array($this, 'addAction'))
      ->bind('admin_add');
    return $userController;
  }

  public function indexAction(Application $app, Request $request)
  {
    $view = array();
    return $app['twig']->render('Admin/index.html.twig', $view);
  }

  public function addAction(Application $app, Request $request)
  {
    $view = array();
    return $app['twig']->render('Admin/add.html.twig', $view);
  }
}
