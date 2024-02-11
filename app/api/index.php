<?php

use Auryn\Injector;
use MMS\Api\Configuration\InjectorConfig;
use MMS\Api\Network\Router;
use Symfony\Component\HttpFoundation\Request;

require_once("vendor/autoload.php");

$injector = new Injector();
InjectorConfig::Setup($injector);

/** @var Router */
$router = $injector->make(Router::class);

$request = Request::createFromGlobals();
$response = $router->run($request);
$response->send();
