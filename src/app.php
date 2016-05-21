<?php

use Silex\Application;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\UrlGeneratorServiceProvider;
use Silex\Provider\TranslationServiceProvider;
use Silex\Provider\DoctrineServiceProvider;
use Silex\Provider\FormServiceProvider;
use Silex\Provider\ValidatorServiceProvider;
use Silex\Provider\SessionServiceProvider;
use Silex\Provider\SecurityServiceProvider;

$app = new Application();

$app->register(
  new TwigServiceProvider(),
  array(
    'twig.path' => __DIR__ . '/views'
  )
);

$app->register(new UrlGeneratorServiceProvider());

$app->register(
  new TranslationServiceProvider(),
  array(
    'locale' => 'pl',
    'locale_fallbacks' => array('en', 'pl')
  )
);

$app['translator']->addResource('xliff', __DIR__ . '/locales/en.xlf', 'en');

$detectedLocale = $app['translator']->getLocale();
$app['translator']->addResource(
  'xliff',
  __DIR__ . '/locales/' . $detectedLocale . '.xlf',
  $detectedLocale
);

// Heroku JawsDB MySQL add-on
// https://devcenter.heroku.com/articles/jawsdb#using-with-php
$url = getenv('JAWSDB_URL');
if ($url == FALSE) {
  $hostname = 'localhost';
  $username = 'root';
  $password = 'root';
  $database = 'srtp2';
} else {
  $dbparts = parse_url($url);

  $hostname = $dbparts['host'];
  $username = $dbparts['user'];
  $password = $dbparts['pass'];
  $database = ltrim($dbparts['path'], '/');
}

$app->register(
  new DoctrineServiceProvider(),
  array(
    'db.options' => array(
      'driver' => 'pdo_mysql',
      'host' => $hostname,
      'dbname' => $database,
      'user' => $username,
      'password' => $password,
      'charset' => 'utf8',
      'driverOptions' => array(
        1002 => 'SET NAMES utf8'
      )
    )
  )
);

$app->register(new FormServiceProvider());

$app->register(new ValidatorServiceProvider());

$app->register(new SessionServiceProvider());

$app->register(
  new SecurityServiceProvider(),
  array(
    'security.firewalls' => array(
      'admin' => array(
        'pattern' => '^.*$',
        'form' => array(
          'login_path' => 'auth_login',
          'check_path' => 'auth_login_check',
          'default_target_path'=> '/',
          'username_parameter' => 'login_form[email]',
          'password_parameter' => 'login_form[password]',
        ),
        'anonymous' => true,
        'logout' => array(
          'logout_path' => 'auth_logout',
          'target_url' => '/'
        ),
        'users' => $app->share(
          function() use ($app)
          {
            return new Provider\UserProvider($app);
          }
        )
      )
    ),
    'security.access_rules' => array(
      array('^/auth.+$', 'IS_AUTHENTICATED_ANONYMOUSLY'),
      array('^/signup/$', 'IS_AUTHENTICATED_ANONYMOUSLY'),
      array('^/user/$', 'ROLE_USER'),
      array('^/project/book$', 'ROLE_USER'),
      array('^/project/submit$', 'ROLE_USER'),
      array('^/project/summary$', 'ROLE_USER'),
      array('^/.+$', 'ROLE_MOD')
    ),
    'security.role_hierarchy' => array(
      'ROLE_ADMIN' => array('ROLE_MOD'),
    )
  )
);

return $app;
