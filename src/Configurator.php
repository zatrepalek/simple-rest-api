<?php
declare(strict_types=1);

namespace UserApi;

use Lokhman\Silex\Provider\ConfigServiceProvider;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use UserApi\Response\IResponse;
use UserApi\Response\SimpleResponse;

class Configurator
{
    /**
     * @param Application $app
     */
    public static function configure(Application $app): void
    {
        self::configureServices($app);
        self::configureErrorHandling($app);
        self::configureRoutes($app);
    }

    /**
     * @param Application $app
     */
    private static function configureServices(Application $app): void
    {
        $app->register(new ConfigServiceProvider(), [
            'config.dir' => __DIR__ . '/../app/config',
        ]);
        $app['response.default'] = function () {
            return new SimpleResponse();
        };
    }

    /**
     * @param Application $app
     */
    private static function configureErrorHandling(Application $app): void
    {
        $app->error(function (\Exception $e, Request $request, int $code) use ($app) {
            $response = $app['response.default'];
            if ($e instanceof HttpException) {
                $response->setStatusCode($code);
                $response->addError($e->getMessage());
            } else {
                $response->setStatusCode($code);
                $response->addError(IResponse::MESSAGE_SERVER_ERROR);
            }
            return $response->build();
        });
    }

    /**
     * @param Application $app
     */
    private static function configureRoutes(Application $app): void
    {
    }
}
