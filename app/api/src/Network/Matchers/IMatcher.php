<?php

declare(strict_types=1);

namespace MMS\Api\Network\Matchers;

use Symfony\Component\HttpFoundation\Request;

interface IMatcher {
  public function findRoute(Request $request);
}
