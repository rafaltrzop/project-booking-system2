<?php

use Silex\Application;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\UrlGeneratorServiceProvider;
use Silex\Provider\TranslationServiceProvider;
use Silex\Provider\DoctrineServiceProvider;
use Silex\Provider\FormServiceProvider;
use Silex\Provider\ValidatorServiceProvider;
use Silex\Provider\SessionServiceProvider;

$app = new Application();

$app->register(
  new TwigServiceProvider(),
  array(
    'twig.path' => __DIR__ . '/views',
  )
);

$app->register(new UrlGeneratorServiceProvider());

$app->register(
  new TranslationServiceProvider(),
  array(
    'locale' => 'pl',
    'locale_fallbacks' => array('en', 'pl'),
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
    ),
  )
);

$app->register(new FormServiceProvider());

$app->register(new ValidatorServiceProvider());

$app->register(new SessionServiceProvider());

return $app;
