<?php
/**
 * Submission controller.
 */

namespace Controller;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Model\Users;
use Model\Submissions;
use Form\RateSubmissionType;

/**
 * Class SubmissionController.
 *
 * @package Controller
 */
class SubmissionController implements ControllerProviderInterface
{
    /**
     * Routing settings.
     *
     * @param \Silex\Application $app Silex application
     * @return \Silex\ControllerCollection Result
     */
    public function connect(Application $app)
    {
        $submissionController = $app['controllers_factory'];
        $submissionController->match('/rate', array($this, 'rateAction'))
            ->bind('submission_rate');
        return $submissionController;
    }

    /**
     * Rate action.
     *
     * @param \Silex\Application $app Silex application
     * @param \Symfony\Component\HttpFoundation\Request $request Request object
     * @return RedirectResponse|string Response
     */
    public function rateAction(Application $app, Request $request)
    {
        try {
            $view = array();

            $userModel = new Users($app);
            $modUserId = $userModel->getCurrentUserId();

            $submisssionModel = new Submissions($app);
            $view['submissions'] = $submisssionModel->findSubmissionsForMod($modUserId);

            $rateForms = array();
            foreach ($view['submissions'] as $row) {
                $rateForms[] = $app['form.factory']->createBuilder(
                    new RateSubmissionType(),
                    $row
                )->getForm();
            }

            $rateFormsView = array();
            foreach ($rateForms as $rateForm) {
                $rateForm->handleRequest($request);

                if ($rateForm->isValid()) {
                    $rateData = $rateForm->getData();
                    $submisssionModel->rateSubmission($rateData);

                    $app['session']->getFlashBag()->add(
                        'message',
                        array(
                            'type' => 'success',
                            'icon' => 'check',
                            'content' => $app['translator']->trans('submission.rate-messages.success')
                        )
                    );

                    return $app->redirect(
                        $app['url_generator']->generate('submission_rate')
                    );
                }

                $rateFormsView[] = $rateForm->createView();
            }

            $view['forms'] = $rateFormsView;

            return $app['twig']->render('Submission/rate.html.twig', $view);
        } catch (\PDOException $e) {
            $app['session']->getFlashBag()->add(
                'message',
                array(
                    'type' => 'alert',
                    'icon' => 'times',
                    'content' => $app['translator']->trans('none.messages.db-error')
                )
            );

            return $app->redirect(
                $request->headers->get('referer')
            );
        }
    }
}
