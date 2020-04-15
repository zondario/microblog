<?php

use Doctrine\ORM\Tools\Console\ConsoleRunner;

$entityManager = require 'init_doctrine_em.php';

return ConsoleRunner::createHelperSet($entityManager);
