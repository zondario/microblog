<?php

use App\Entity\User;

require __DIR__.'/../../../vendor/autoload.php';

$entityManager = \App\Config\DoctrineEntityManagerFactory::create();
$user = new User();
$user->setCreatedAt(new DateTime());
$user->setFirstName('Admin');
$user->setLastName('Admin');
$user->setUsername('admin');
$user->setPassword(password_hash('adminAdmin123!@#', PASSWORD_BCRYPT));
$entityManager->persist($user);
$entityManager->flush();