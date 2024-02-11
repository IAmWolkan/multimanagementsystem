<?php

declare(strict_types=1);

namespace MMS\Api\Network\Factories;

interface IFactory {
  public function create(string $name);
}
