<?php

use Doctrine\ORM\Tools\Console\ConsoleRunner;

$entityManager = \App\Config\DoctrineEntityManagerFactory::create();

return ConsoleRunner::createHelperSet($entityManager);
