<?php
/**
 * Index controller.
 */

namespace Controller;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class IndexController.
 *
 * @package Controller
 */
class IndexController implements ControllerProviderInterface
{
  /**
   * Routing settings.
   *
   * @param Silex\Application $app Silex application
   * @return Silex\ControllerCollection Result
   */
  public function connect(Application $app)
  {
    $indexController = $app['controllers_factory'];
    $indexController->get('/', array($this, 'indexAction'));
    return $indexController;
  }

  /**
   * Index action.
   *
   * @param Silex\Application $app Silex application
   * @param Symfony\Component\HttpFoundation\Request $request Request object
   * @return string Response
   * @todo Return value mixed because of possible redirect?
   */
  public function indexAction(Application $app, Request $request)
  {
    if ($app['security.authorization_checker']->isGranted('ROLE_MOD')) {
      return $app->redirect(
        $app['url_generator']->generate('admin')
      );
    }

    if ($app['security.authorization_checker']->isGranted('ROLE_USER')) {
      return $app->redirect(
        $app['url_generator']->generate('user_redirect')
      );
    }

    return $app['twig']->render('Index/index.html.twig');
  }
}
