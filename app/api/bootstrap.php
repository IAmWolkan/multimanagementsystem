<?php

declare(strict_types=1);

use Auryn\Injector;
use MMS\Api\Configuration\InjectorConfig;

require_once("vendor/autoload.php");

$injector = new Injector();
InjectorConfig::Setup($injector);
