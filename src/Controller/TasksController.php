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
use Model\Tasks;

/**
 * Class TasksController.
 *
 * @package Controller
 * @author Tomasz Chojna
 */
class TasksController implements ControllerProviderInterface
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
    $tasksController = $app['controllers_factory'];
    $tasksController->get('/', array($this, 'indexAction'));
    $tasksController->get('/index', array($this, 'indexAction'));
    $tasksController->get('/index/', array($this, 'indexAction'));
    $tasksController->get('/view/{id}', array($this, 'viewAction'));
    $tasksController->get('/view/{id}/', array($this, 'viewAction'))
      ->bind('tasks-view');
    return $tasksController;
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
    $tasksModel = new Tasks();
    $view['tasks'] = $tasksModel->findAll();
    return $app['twig']->render('Tasks/index.html.twig', $view);
  }

  public function viewAction(Application $app, Request $request)
  {
    $view = array();
    $tasksModel = new Tasks();
    $id = (integer) $request->get('id', 0);
    $view['tasks'] = $tasksModel->find($id);
    return $app['twig']->render('Tasks/view.html.twig', $view);
  }
}
