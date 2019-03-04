<?php
/**
 * Created by PhpStorm.
 * User: arman
 * Date: 28/10/2018
 * Time: 12:17
 */

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

$paths = [
    __DIR__ . '/Entity'
];

$isDevMode = true;

$dbParams = [
    'driver' => 'pdo_mysql',
    'user' => 'root',
    'password' => 'root',
    'dbname' => 'doctrine_basico'
];

$config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode);
$entityManager = EntityManager::create($dbParams, $config);

function getEntityManager()
{
    global $entityManager;
    return $entityManager;
}