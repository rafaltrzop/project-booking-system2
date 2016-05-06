<?php

namespace Controller;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;

class RegistrationController implements ControllerProviderInterface
{
  public function connect(Application $app)
  {
    $registrationController = $app['controllers_factory'];
    $registrationController->get('/', array($this, 'indexAction'))
      ->bind('registration');
    return $registrationController;
  }

  public function indexAction(Application $app, Request $request)
  {
    return $app['twig']->render('Registration/index.html.twig');
  }
}
