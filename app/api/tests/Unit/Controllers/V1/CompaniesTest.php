<?php

declare(strict_types=1);

namespace MMS\Tests\Unit\Api\Controllers\V1;

use MMS\Api\Controllers\V1\Companies;
use MMS\Tests\TestCase;
use Symfony\Component\HttpFoundation\Request;

class CompaniesTest extends TestCase {
  private Companies $controller;

  public function setUp(): void {
    $this->controller = new Companies();
  }

  public function testGet() {
    $request = new Request();
    $response = $this->controller->get($request);
    $this->assertEquals(200, $response->getStatusCode());
  }
}
