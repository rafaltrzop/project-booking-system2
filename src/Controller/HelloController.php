<?php
/**
 * Hello controller.
 *
 * @copyright (c) 2016 Tomasz Chojna
 * @link http://epi.chojna.info.pl
 */

namespace Controller;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class HelloController.
 *
 * @package Controller
 * @author Tomasz Chojna
 */
class HelloController implements ControllerProviderInterface
{
  /**
   * Routing settings.
   *
   * @access public
   * @param Silex\Application $app Silex application
   * @return Silex\ControllerCollection Result
   */
  public function connect(Application $app)
  {
    $helloController = $app['controllers_factory'];
    $helloController->get('/{name}', array($this, 'indexAction'));
    return $helloController;
  }

  /**
   * Index action.
   *
   * @access public
   * @param Silex\Application $app Silex application
   * @param Symfony\Component\HttpFoundation\Request $request Request object
   * @return string Response
   */
  public function indexAction(Application $app, Request $request)
  {
    $view = array();
    $view['name'] = (string)$request->get('name', '');
    return $app['twig']->render('Hello/index.html.twig', $view);
  }
}
