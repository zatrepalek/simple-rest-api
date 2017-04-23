<?php
declare(strict_types=1);

namespace UserApi\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class UserController
{
    public function default(Request $request, Application $app): JsonResponse
    {
        return new JsonResponse(['foo' => 'bar']);
    }
}
