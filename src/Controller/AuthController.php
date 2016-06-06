<?php
/**
 * Auth controller.
 */

namespace Controller;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Form\LogInType;

/**
 * Class AuthController.
 *
 * @package Controller
 */
class AuthController implements ControllerProviderInterface
{
  /**
   * Routing settings.
   *
   * @param Application $app Silex application
   * @return ControllerCollection Result
   */
  public function connect(Application $app)
  {
    $authController = $app['controllers_factory'];
    $authController->match('/login', array($this, 'loginAction'))
      ->bind('auth_login');
    // $authController->get('/logout', array($this, 'logoutAction'))
    //   ->bind('auth_logout');
    return $authController;
  }

  /**
   * Login action.
   *
   * @param Application $app Silex application
   * @param Request $request Request object
   * @return string Output
   */
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

  /**
   * Logout action.
   *
   * @param Application $app Silex application
   * @return string Output
   */
  // public function logoutAction(Application $app)
  // {
  //   $view = array();
  //   $app['session']->clear();
  //   return $app['twig']->render('Auth/logout.html.twig', $view);
  // }
}
