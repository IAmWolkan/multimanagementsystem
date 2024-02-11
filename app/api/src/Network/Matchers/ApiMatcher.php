<?php

declare(strict_types=1);

namespace MMS\Api\Network\Matchers;

use MMS\Api\Network\Exceptions\MissingMethodException;
use MMS\Api\Network\Factories\ControllerFactory;
use Symfony\Component\HttpFoundation\{Request, Response};

class ApiMatcher implements IMatcher {
  private ControllerFactory $factory;

  public function __construct(ControllerFactory $factory) {
    $this->factory = $factory;
  }

  public function findRoute(Request $request): Response {
    list($version, $controllerName, $method) = $this->parseRequest($request);
    

    $this->factory->setVersion($version);    
    $controller = $this->factory->create($controllerName);

    if(!method_exists($controller, $method))
      throw new MissingMethodException("Could not find method $method in controller $controllerName");

    return $controller->$method($request);
  }

  private function parseRequest(Request $request) {
    $path = $request->getPathInfo();
    if(str_starts_with($path, '/'))
      $path = substr($path, 1);

    if(!str_ends_with($path, '/'))
      $path .= '/';

    list($version, $controller, $entityId) = explode('/', $path);
    $method = $request->getMethod();

    if($entityId !== null) {
      $request->attributes->set('entityId', $entityId);
    }

    return [$version, $controller, $method];
  }
}
