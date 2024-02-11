<?php

declare(strict_types=1);

namespace MMS\Api\Configuration;

use Auryn\Injector;
use MMS\Api\Network\Factories\{
  ControllerFactory,
  MatcherFactory
};
use MMS\Api\Network\Matchers\ApiMatcher;
use MMS\Api\Network\Router;
use Monolog\Handler\ErrorLogHandler;
use Monolog\{
  Level,
  Logger
};

class InjectorConfig {
  public static function Setup(Injector $injector) {
    $logger = new Logger('api');
    $logger->pushHandler(new ErrorLogHandler(ErrorLogHandler::OPERATING_SYSTEM, Level::Debug));
    $injector->delegate(Logger::class, function()use($logger) {
      return $logger;
    });

    $injector->define(Router::class, [':matcherClasses' => [
      ApiMatcher::class
    ]]);

    $injector->define(ControllerFactory::class, [':injector' => $injector]);
    $injector->define(MatcherFactory::class, [':injector' => $injector]);
  }
}
