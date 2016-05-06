<?php

namespace Controller;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;

class SignUpController implements ControllerProviderInterface
{
  public function connect(Application $app)
  {
    $signUpController = $app['controllers_factory'];
    $signUpController->get('/', array($this, 'indexAction'))
      ->bind('signup');
    return $signUpController;
  }

  public function indexAction(Application $app, Request $request)
  {
    return $app['twig']->render('SignUp/index.html.twig');
  }
}
