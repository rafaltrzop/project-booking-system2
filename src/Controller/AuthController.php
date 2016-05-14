<?php

namespace Controller;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Form\LogInType;

class AuthController implements ControllerProviderInterface
{
  public function connect(Application $app)
  {
    $authController = $app['controllers_factory'];
    $authController->match('/login', array($this, 'loginAction'))
      ->bind('auth_login');
    $authController->get('/logout', array($this, 'logoutAction'))
      ->bind('auth_logout');
    return $authController;
  }

  public function loginAction(Application $app, Request $request)
  {
    $user = array(
      'login' => $app['session']->get('_security.last_username')
    );

    $form = $app['form.factory']->createBuilder(
      new LogInType(),
      $user
    )->getForm();

    $view = array(
      'form' => $form->createView(),
      'error' => $app['security.last_error']($request)
    );

    return $app['twig']->render('Auth/login.html.twig', $view);
  }

  public function logoutAction(Application $app)
  {
    $view = array();
    $app['session']->clear();
    return $app['twig']->render('Auth/logout.html.twig', $view);
  }
}