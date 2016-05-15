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
    if ($app['security.authorization_checker']->isGranted('ROLE_USER')) {
      return $app->redirect(
        $app['url_generator']->generate('user')
      );
    }

    if ($app['security.authorization_checker']->isGranted('ROLE_MOD')) {
      return $app->redirect(
        $app['url_generator']->generate('admin')
      );
    }

    return $app['twig']->render('Index/index.html.twig');
  }
}
