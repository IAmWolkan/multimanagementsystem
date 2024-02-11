<?php

require_once("vendor/autoload.php");

/**
 * This is project's console commands configuration for Robo task runner.
 *
 * @see https://robo.li/
 */
class RoboFile extends \Robo\Tasks
{
  public function dbUpdateSchema() {
    $this->taskExec('php bin/doctrine orm:schema-tool:update')->run();
  }

  public function dbCreateSchema() {
    $this->taskExec('php bin/doctrine orm:schema-tool:create')->run();
  }

  public function dbDropSchema() {
    $this->taskExec('php bin/doctrine orm:schema-tool:drop --force')->run();
  }

  public function dbDumpSchema() {
    $this->taskExec('php bin/doctrine orm:schema-tool:drop --dump-sql')->run();
  }

  public function dbValidateSchema() {
    $this->taskExec('php bin/doctrine orm:validate-schema')->run();
  }

  public function testUnit() {
    $this->taskExec('vendor/bin/phpunit tests/Unit')->run();
  }
}
