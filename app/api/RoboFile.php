<?php
/**
 * This is project's console commands configuration for Robo task runner.
 *
 * @see https://robo.li/
 */
class RoboFile extends \Robo\Tasks
{
    public function testUnit() {
        $this->taskExec('vendor/bin/phpunit tests/Unit')->run();
    }
}
