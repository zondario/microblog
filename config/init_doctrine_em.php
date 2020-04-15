<?php
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;

// replace with mechanism to retrieve EntityManager in your app
$isDevMode = true;
$proxyDir = null;
$cache = null;
$useSimpleAnnotationReader = false;
$config = Setup::createAnnotationMetadataConfiguration(array(__DIR__."/../src/"), $isDevMode, $proxyDir, $cache, $useSimpleAnnotationReader);
// or if you prefer yaml or XML
//$config = Setup::createXMLMetadataConfiguration(array(__DIR__."/config/xml"), $isDevMode);
//$config = Setup::createYAMLMetadataConfiguration(array(__DIR__."/config/yaml"), $isDevMode);

// database configuration parameters
$conn = array(
    'driver' => 'pdo_mysql',
    'host' => 'localhost',
    'port' => 3306,
    'dbname' => 'microblog',
    'user' => 'root',
    'password' => '',
);

// obtaining the entity manager
$entityManager = EntityManager::create($conn, $config);
return $entityManager;