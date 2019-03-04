<?php
/**
 * Created by PhpStorm.
 * User: arman
 * Date: 28/10/2018
 * Time: 12:15
 */

// replace with file to your own project bootstrap
require_once __DIR__ . '/src/bootstrap.php';

// replace with mechanism to retrieve EntityManager in your app
$entityManager = getEntityManager();

return \Doctrine\ORM\Tools\Console\ConsoleRunner::createHelperSet($entityManager);