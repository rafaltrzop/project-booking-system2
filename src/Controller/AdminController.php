<?php
/**
 * Admin controller.
 */

namespace Controller;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class AdminController.
 *
 * @package Controller
 */
class AdminController implements ControllerProviderInterface
{
    /**
     * Routing settings.
     *
     * @param \Silex\Application $app Silex application
     * @return \Silex\ControllerCollection Result
     */
    public function connect(Application $app)
    {
        $adminController = $app['controllers_factory'];
        $adminController->get('/', array($this, 'indexAction'))
        ->bind('admin');
        $adminController->get('/add', array($this, 'addAction'))
        ->bind('admin_add');
        $adminController->get('/edit', array($this, 'editAction'))
        ->bind('admin_edit');
        $adminController->get('/delete', array($this, 'deleteAction'))
        ->bind('admin_delete');
        return $adminController;
    }

    /**
     * Index action.
     *
     * @param \Silex\Application $app Silex application
     * @param \Symfony\Component\HttpFoundation\Request $request Request object
     * @return string Response
     */
    public function indexAction(Application $app, Request $request)
    {
        return $app['twig']->render('Admin/index.html.twig');
    }

    /**
     * Add action.
     *
     * @param \Silex\Application $app Silex application
     * @param \Symfony\Component\HttpFoundation\Request $request Request object
     * @return string Response
     */
    public function addAction(Application $app, Request $request)
    {
        return $app['twig']->render('Admin/add.html.twig');
    }

    /**
     * Edit action.
     *
     * @param \Silex\Application $app Silex application
     * @param \Symfony\Component\HttpFoundation\Request $request Request object
     * @return string Response
     */
    public function editAction(Application $app, Request $request)
    {
        return $app['twig']->render('Admin/edit.html.twig');
    }

    /**
     * Delete action.
     *
     * @param \Silex\Application $app Silex application
     * @param \Symfony\Component\HttpFoundation\Request $request Request object
     * @return string Response
     */
    public function deleteAction(Application $app, Request $request)
    {
        return $app['twig']->render('Admin/delete.html.twig');
    }
}
