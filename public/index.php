<?php

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
$app->add(new \Slim\Middleware\Session(array(
    'name' => 'session',
    'autorefresh' => true,
    'lifetime' => '1 hour'
)));
\App\Config\ContainerBuilder::build($app);


// Define routes
$app->get('/', 'App\Controller\Index:execute')->name('home');
$app->get('/admin/login', 'App\Controller\Admin\AuthenticationController:login')->name('login');
$app->post('/admin/login', 'App\Controller\Admin\AuthenticationController:loginPost')->name('loginPost');

// Run app
$app->run();
