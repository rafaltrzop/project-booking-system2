<?php
/**
 * Runs application and loads configs.
 *
 * @copyright (c) 2016 Tomasz Chojna
 * @link http://epi.chojna.info.pl
 */

use Silex\Application;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\UrlGeneratorServiceProvider;
use Silex\Provider\TranslationServiceProvider;
use Silex\Provider\DoctrineServiceProvider;

$app = new Application();

$app->register(
  new TwigServiceProvider(),
  array(
    'twig.path' => dirname(dirname(__FILE__)) . '/src/views',
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

// dodanie domyślnych tłumaczeń w języku angielskim:
$app['translator']->addResource(
  'xliff',
  dirname(dirname(__FILE__)) . '/src/locales/en.xlf',
  'en'
);

// załadowanie tłumaczeń bazujących na lokalizacji użytkownika:
$locadedLocale = $app['translator']->getLocale();
$app['translator']->addResource(
  'xliff',
  dirname(dirname(__FILE__)) . '/src/locales/' . $locadedLocale . '.xlf',
  $locadedLocale
);

// Heroku JawsDB MySQL add-on
// https://devcenter.heroku.com/articles/jawsdb#using-with-php
$url = getenv('JAWSDB_URL');
if ($url != FALSE) {
  $dbparts = parse_url($url);

  $hostname = $dbparts['host'];
  $username = $dbparts['user'];
  $password = $dbparts['pass'];
  $database = ltrim($dbparts['path'],'/');
} else {
  $hostname = 'localhost';
  $username = 'root';
  $password = 'root';
  $database = 'srtp2';
}

$app->register(
  new DoctrineServiceProvider(),
  array(
    'db.options' => array(
      'driver'    => 'pdo_mysql',
      'host'      => $hostname,
      'dbname'    => $database,
      'user'      => $username,
      'password'  => $password,
      'charset'   => 'utf8',
      'driverOptions' => array(
        1002 => 'SET NAMES utf8'
      )
    ),
  )
);

return $app;
