<?php

declare(strict_types=1);

namespace MMS\Api\Network\Factories;

use Auryn\Injector;
use MMS\Api\Network\Exceptions\MissingMatcherException;
use MMS\Api\Network\Matchers\IMatcher;

class MatcherFactory implements IFactory {
  private Injector $injector;

  public function __construct(Injector $injector) {
    $this->injector = $injector;
  }
  
  public function create(string $name): IMatcher {
    if(!class_exists($name))
      throw new MissingMatcherException();

    return $this->injector->make($name);
  }
}
