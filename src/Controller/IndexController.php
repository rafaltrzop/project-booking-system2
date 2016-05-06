<?php

namespace Controller;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;

class IndexController implements ControllerProviderInterface
{
  public function connect(Application $app)
  {
    $indexController = $app['controllers_factory'];
    $indexController->get('/', array($this, 'indexAction'));
    return $indexController;
  }

  public function indexAction(Application $app, Request $request)
  {
    return $app['twig']->render('Index/index.html.twig');
  }
}
