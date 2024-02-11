<?php

declare(strict_types=1);

namespace MMS\Api\Configuration;

use Auryn\Injector;
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\{
  EntityManager,
  ORMSetup
};
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
    self::loadConfig();

    $entityManager = self::setupEntityManager();
    $injector->delegate(EntityManager::class, function()use($entityManager) {
      return $entityManager;
    });

    // Configure loggins
    $logger = new Logger(AppConfig::get('logger.name'));
    $logger->pushHandler(new ErrorLogHandler(ErrorLogHandler::OPERATING_SYSTEM, Level::Debug));
    $injector->delegate(Logger::class, function()use($logger) {
      return $logger;
    });

    // Configure networking
    $injector->define(Router::class, [':matcherClasses' => [
      ApiMatcher::class
    ]]);

    // Configure factories
    $injector->define(ControllerFactory::class, [':injector' => $injector]);
    $injector->define(MatcherFactory::class, [':injector' => $injector]);
  }

  private static function setupEntityManager() {
    // Create a simple "default" Doctrine ORM configuration for Attributes
    $metaConfig = ORMSetup::createAttributeMetadataConfiguration(
      paths: array(__DIR__."/../Entities"),
      isDevMode: true,
    );

    $dbParams = [
      'dbname' => AppConfig::get('database.dbname'),
      'user' => AppConfig::get('database.username'),
      'password' => AppConfig::get('database.password'),
      'host' => AppConfig::get('database.host'),
      'driver' => 'pdo_mysql',
    ];
    // configuring the database connection
    $connection = DriverManager::getConnection($dbParams, $metaConfig);

    // obtaining the entity manager
    return new EntityManager($connection, $metaConfig);
  }

  private static function loadConfig() {
    $config = \yaml_parse(file_get_contents("config.yml"));
    AppConfig::setConfig($config);
  }
}
