<?php

namespace Controller;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Model\Submissions;

class SubmissionController implements ControllerProviderInterface
{
  public function connect(Application $app)
  {
    $submissionController = $app['controllers_factory'];
    $submissionController->get('/rate', array($this, 'rateAction'))
      ->bind('submission_rate');
    return $submissionController;
  }

  public function rateAction(Application $app, Request $request)
  {
    $view = array();
    // $groupModel = new Groups($app);
    //
    // $addForm = $app['form.factory']->createBuilder(
    //   new ProjectType($groupModel->findAllGroups())
    // )->getForm();
    //
    // $addForm->handleRequest($request);
    //
    // if ($addForm->isValid()) {
    //   $addData = $addForm->getData();
    //
    //   $projectModel = new Projects($app);
    //   $projectModel->createProject($addData);
    //
    //   $app['session']->getFlashBag()->add(
    //     'message',
    //     array(
    //       'type' => 'success',
    //       'icon' => 'check',
    //       'content' => $app['translator']->trans('project.add-messages.success')
    //     )
    //   );
    //
    //   return $app->redirect(
    //     $app['url_generator']->generate('project_add')
    //   );
    // }
    //
    // $view['form'] = $addForm->createView();

    $submisssionModel = new Submissions($app);
    $view['submissions'] = $submisssionModel->findAllSubmissions();

    return $app['twig']->render('Submission/rate.html.twig', $view);
  }
}
