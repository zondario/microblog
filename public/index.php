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

$app->view->getEnvironment()->addGlobal('authManager', $app->container[\App\Services\Security\AuthenticationManagerInterface::class]);
$app->view->getEnvironment()->addGlobal('router', $app->router);
// Define routes
$app->get('/', 'App\Controller\Index:execute')->name('home');
$app->get('/admin/login', 'App\Controller\Admin\AuthenticationController:login')->name('login');
$app->post('/admin/login', 'App\Controller\Admin\AuthenticationController:loginPost')->name('loginPost');
$app->get('/admin/logout', 'App\Controller\Admin\AuthenticationController:logout')->name('logout');
$app->get('/admin/users/create', 'App\Controller\Admin\UsersController:create')->name('users_create');
$app->post('/admin/users/create', 'App\Controller\Admin\UsersController:createPost')->name('users_create_post');
$app->get('/admin/posts/create', 'App\Controller\Admin\PostController:create')->name('posts_create');
$app->post('/admin/posts/create', 'App\Controller\Admin\PostController:createPost')->name('posts_create_post');
$app->post('/admin/posts/edit/:id', 'App\Controller\Admin\PostController:edit')->name('post_edit');
$app->get('/admin/posts/list(/:page)', 'App\Controller\Admin\PostController:listAll')->name('posts_admin_list');
$app->get('/admin/posts/delete/:id', 'App\Controller\Admin\PostController:delete')->name('posts_delete');

// Run app
$app->run();
