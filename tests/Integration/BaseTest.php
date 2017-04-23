<?php
declare(strict_types=1);

namespace Tests\Integration;

use Silex\Application;
use Silex\WebTestCase;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use UserApi\Configurator;

abstract class BaseTest extends WebTestCase
{
    public const HEADER_CONTENT_TYPE = [
        'CONTENT_TYPE' => 'application/json'
    ];

    /**
     * Creates the application.
     *
     * @return HttpKernelInterface
     */
    public function createApplication(): HttpKernelInterface
    {
        $app = new Application();

        Configurator::configure($app);

        $app['debug'] = true;
        $app['config.env'] = 'test';
        unset($app['exception_handler']);

        return $app;
    }
}
