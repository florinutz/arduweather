<?php
use Symfony\Component\Debug\ErrorHandler;
use Symfony\Component\Debug\ExceptionHandler;

require_once('./vendor/autoload.php');

ini_set('display_errors', 1);
error_reporting(-1);
ErrorHandler::register();
if ('cli' !== php_sapi_name()) {
    ExceptionHandler::register();
}

$app = new Silex\Application();

$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'db.options' => array(
        'driver'   => 'pdo_sqlite',
        'path'     => __DIR__.'/../weather.db',
    ),
));

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/views',
));

$app['recommender'] = function($app) {
    return new \Flo\RecommenderService($app['db']);
};

$app->get('/', function() use($app) {
    /** @var \Symfony\Bridge\Twig\TwigEngine $twig */
    $twig = $app['twig'];
    return $twig->render('index.twig');
});

$app['debug'] = true;

$app->run();
