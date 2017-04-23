<?php
declare(strict_types=1);

namespace UserApi;

use Silex\Application;

class Configurator
{
    /**
     * @param Application $app
     */
    public static function configure(Application $app): void
    {
        self::configureServices($app);
        self::configureRoutes($app);
    }

    /**
     * @param Application $app
     */
    private static function configureServices(Application $app): void
    {
        // TODO
    }

    /**
     * @param Application $app
     */
    private static function configureRoutes(Application $app): void
    {
        $app->get('/', 'UserApi\\Controller\\UserController::default');
    }
}
