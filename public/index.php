<?php

use Doctrine\ORM\EntityManager;

require '../vendor/autoload.php';

// Prepare app
$app = new \RKA\Slim(array(
    'templates.path' => '../src/view',
));
// Prepare view
$app->view(new \Slim\Views\Twig());
$app->view->parserOptions = array(
    'charset' => 'utf-8',
    'cache' => realpath('../src/view/cache'),
    'auto_reload' => true,
    'strict_variables' => false,
    'autoescape' => true,
    'debug' => true
);
$app->view->parserExtensions = array(new \Slim\Views\TwigExtension(), new \Twig_Extension_Debug());

// Create monolog logger and store logger in container as singleton 
// (Singleton resources retrieve the same log resource definition each time)
$app->container->singleton('log', function () {
    $log = new \Monolog\Logger('slim-skeleton');
    $log->pushHandler(new \Monolog\Handler\StreamHandler('../logs/app.log', \Monolog\Logger::DEBUG));
    return $log;
});
$app->container->singleton('entityManager', function(){
    /**
     * @var EntityManager
     */
    $entityManager = require '../config/init_doctrine_em.php';
    return $entityManager;
});
$app->container->singleton('App\Controller\Index', function ($container) use($app) {
   return new \App\Controller\Index($container['entityManager'], $app->view);
});



// Define routes
$app->get('/', 'App\Controller\Index:execute');

// Run app
$app->run();
