<?php
/**
 * Tags controller.
 *
 * @copyright (c) 2016 Tomasz Chojna
 * @link http://epi.chojna.info.pl
 */

namespace Controller;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Model\Tags;

/**
 * Class TagsController.
 *
 * @package Controller
 * @author Tomasz Chojna
 */
class TagsController implements ControllerProviderInterface
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
    $tagsController = $app['controllers_factory'];
    $tagsController->get('/', array($this, 'indexAction'))
      ->bind('tags');
    $tagsController->get('/index', array($this, 'indexAction'));
    $tagsController->get('/index/', array($this, 'indexAction'));
    $tagsController->get('/view/{id}', array($this, 'viewAction'));
    $tagsController->get('/view/{id}/', array($this, 'viewAction'))
      ->bind('tags-view');
    return $tagsController;
  }

  /**
   * Index action.
   *
   * @access public
   * @param Silex\Application $app Silex application
   * @param Symfony\Component\HttpFoundation\Request $request Request object
   * @return string Output
   */
  public function indexAction(Application $app, Request $request)
  {
    $view = array();
    $tagsModel = new Tags($app);
    $view['tags'] = $tagsModel->findAll();
    return $app['twig']->render('Tags/index.html.twig', $view);
  }

  /**
   * View action.
   *
   * @access public
   * @param Silex\Application $app Silex application
   * @param Symfony\Component\HttpFoundation\Request $request Request object
   * @return string Output
   */
  public function viewAction(Application $app, Request $request)
  {
    $view = array();
    $id = (integer)$request->get('id', null);
    $tagsModel = new Tags($app);
    $view['tag'] = $tagsModel->find($id);
    return $app['twig']->render('Tags/view.html.twig', $view);
  }

}
