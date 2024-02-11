<?php

declare(strict_types=1);

namespace MMS\Api\Controllers\V1;

use MMS\Api\Controllers\Exceptions\NotYetImplementedException;
use Symfony\Component\HttpFoundation\{Request, Response};

class Companies implements IController {
  public function get(Request $request): Response {
    $entityId = $request->attributes->get('entityId');

    return new Response("{\"EntityId\":\"$entityId\"}", 200);
  }

  public function put(Request $request): Response {
    throw new NotYetImplementedException();
  }

  public function post(Request $request): Response {
    throw new NotYetImplementedException();
  }

  public function delete(Request $request): Response {
    throw new NotYetImplementedException();
  }
}
