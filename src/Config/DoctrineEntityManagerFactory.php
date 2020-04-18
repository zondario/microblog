<?php

namespace App\Config;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;

class DoctrineEntityManagerFactory
{
    public static function create()
    {
        // replace with mechanism to retrieve EntityManager in your app
        $isDevMode = true;
        $proxyDir = null;
        $cache = null;
        $useSimpleAnnotationReader = false;
        $config = Setup::createAnnotationMetadataConfiguration([__DIR__ . "/../"], $isDevMode, $proxyDir, $cache, $useSimpleAnnotationReader);
        // or if you prefer yaml or XML
        //$config = Setup::createXMLMetadataConfiguration(array(__DIR__."/config/xml"), $isDevMode);
        //$config = Setup::createYAMLMetadataConfiguration(array(__DIR__."/config/yaml"), $isDevMode);

        // database configuration parameters
        $conn = require __DIR__.'/../../config/doctrine.php';

        // obtaining the entity manager
        $entityManager = EntityManager::create($conn, $config);

        return $entityManager;
    }
}