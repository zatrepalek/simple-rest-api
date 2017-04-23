<?php
declare(strict_types=1);

namespace Tests\Integration;

use Silex\Application;
use Silex\WebTestCase;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use UserApi\Configurator;

class HomeTest extends WebTestCase
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

    public function testHome()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/');

        $this->assertTrue($client->getResponse()->isOk());
    }
}
