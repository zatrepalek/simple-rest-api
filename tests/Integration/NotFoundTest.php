<?php
declare(strict_types=1);

namespace Tests\Integration;

use Silex\Application;
use Silex\WebTestCase;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use UserApi\Configurator;
use UserApi\Response\IResponse;

class NotFoundTest extends WebTestCase
{
    /**
     * Creates the application.
     *
     * @return HttpKernelInterface
     */
    public function createApplication()
    {
        $app = new Application();

        Configurator::configure($app);

        $app['debug'] = true;

        return $app;
    }

    public function testNotFound()
    {
        $client = $this->createClient();
        $client->request('GET', '/');

        $this->assertEquals(IResponse::HTTP_CODE_NOT_FOUND, $client->getResponse()->getStatusCode());
    }
}
