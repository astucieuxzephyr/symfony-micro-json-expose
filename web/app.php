<?php
/* FRONT CONTROLLER to boot and run the application */
use Symfony\Component\HttpFoundation\Request;

$loader = require __DIR__.'/../config/autoload.php';

/* Chargement du MicroKernel */
require_once __DIR__.'/../MicroKernel.php';
// $app = new MicroKernel('prod', false);
$app = new MicroKernel('dev', true);
$app->loadClassCache();

$request = Request::createFromGlobals();
$response = $app->handle($request);
$response->send();
$app->terminate($request, $response);
