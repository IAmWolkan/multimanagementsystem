<?php

declare(strict_types=1);

namespace MMS\Api\Network;

use MMS\Api\Network\Exceptions\{
  MissingControllerException,
  MissingMethodException
};
use MMS\Api\Network\Factories\MatcherFactory;
use Monolog\Logger;
use Symfony\Component\HttpFoundation\{
  Request,
  Response
};

class Router {
  private MatcherFactory $matcherFactory;
  private Logger $logger;
  private array $matcherClasses;

  public function __construct(MatcherFactory $matcherFactory, Logger $logger,
    array $matcherClasses) {
    $this->matcherFactory = $matcherFactory;
    $this->logger = $logger;
    $this->matcherClasses = $matcherClasses;
  }

  public function run(Request $request): Response {
    try {
      foreach($this->matcherClasses as $matcherClass) {
        $matcher = $this->matcherFactory->create($matcherClass);
        $response = $matcher->findRoute($request);
        if($response === null)
          continue;

        return $response;
      }
    } catch(MissingControllerException | MissingMethodException $ex) {
      $this->logger->error($ex->getMessage(), $ex->getTrace());
      return new Response(null, 404);
    }
  }  
}
