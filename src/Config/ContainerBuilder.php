<?php
/**
 * Created by PhpStorm.
 * User: Notebook
 * Date: 16-Apr-20
 * Time: 10:33 PM
 */

namespace App\Config;

use App\Controller\Admin\UsersController;
use App\Services\Security\AuthenticationManagerInterface;
use App\Services\Security\AuthenticationTokenManager;
use App\Services\Security\AuthenticationTokenManagerInterface;
use App\Services\Security\PasswordManagerInterface;
use Doctrine\ORM\EntityManager;

class ContainerBuilder
{
    public static function build($app)
    {
        // Create monolog logger and store logger in container as singleton
// (Singleton resources retrieve the same log resource definition each time)
        $app->container->singleton('log', function () {
            $log = new \Monolog\Logger('slim-skeleton');
            $log->pushHandler(new \Monolog\Handler\StreamHandler('../logs/app.log', \Monolog\Logger::DEBUG));
            return $log;
        });
        $app->container->singleton('session', function () {
            return new \SlimSession\Helper;
        });
        $app->container->singleton('entityManager', function(){
            /**
             * @var EntityManager
             */
            $entityManager = \App\Config\DoctrineEntityManagerFactory::create();
            return $entityManager;
        });
        $app->container->singleton(\App\Controller\Index::class, function ($container) use($app) {
            return new \App\Controller\Index($container['entityManager']);
        });
        $app->container->singleton(\App\Services\Security\PasswordManagerInterface::class, function () {
            return new \App\Services\Security\PasswordManager();
        });
        $app->container->singleton(AuthenticationTokenManagerInterface::class, function ($container) {
            return new AuthenticationTokenManager($container['entityManager']);
        });
        $app->container->singleton(\App\Services\Security\AuthenticationManagerInterface::class, function ($container) {
            return new \App\Services\Security\AuthenticationManager(
                $container['entityManager'],
                $container[\App\Services\Security\PasswordManagerInterface::class],
                $container['session'],
            $container[AuthenticationTokenManagerInterface::class]
            );
        });
        $app->container->singleton(\App\Controller\Admin\AuthenticationController::class, function ($container) use($app) {
            return new \App\Controller\Admin\AuthenticationController(
                $container['entityManager'],
                $container[AuthenticationManagerInterface::class]
            );
        });
        $app->container->singleton(\App\Services\User\ManagerInterface::class, function ($container) use($app) {
            return new \App\Services\User\Manager(
                $container['entityManager'],
                $container[PasswordManagerInterface::class]
            );
        });
        $app->container->singleton(UsersController::class, function ($container) use($app) {
            return new \App\Controller\Admin\UsersController(
                $container[\App\Services\User\ManagerInterface::class],
                $container[AuthenticationManagerInterface::class]
            );
        });

    }
}