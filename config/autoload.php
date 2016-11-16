<?php

use Doctrine\Common\Annotations\AnnotationRegistry;
use Composer\Autoload\ClassLoader;

/**
 * @var ClassLoader $loader
 */
$loader = require __DIR__.'/../vendor/autoload.php';

// To be able to work with annotations we need to load some things
AnnotationRegistry::registerLoader(array($loader, 'loadClass'));

return $loader;
