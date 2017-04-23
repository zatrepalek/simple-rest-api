<?php
declare(strict_types=1);

namespace UserApi\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use UserApi\Response\IResponse;
use UserApi\Response\SimpleResponse;

final class UserController
{
    /** @var false|\stdClass */
    protected $requestBody;

    /**
     * @param Request $request
     * @throws \LogicException
     * @throws HttpException
     */
    private function parseRequest(Request $request): void
    {
        if ($request->getContent() !== '' && strpos($request->headers->get('Content-Type'), 'application/json') === 0) {
            $this->requestBody = json_decode($request->getContent());
            if ($this->requestBody === false || !is_a($this->requestBody, \stdClass::class)) {
                $this->throwBadRequestException();
            }
        }
    }

    /**
     * @throws HttpException
     */
    private function throwBadRequestException()
    {
        throw new BadRequestHttpException(
            IResponse::MESSAGE_BAD_REQUEST,
            null,
            IResponse::HTTP_CODE_BAD_REQUEST
        );
    }

    /**
     * @throws HttpException
     */
    private function throwInternalException()
    {
        throw new HttpException(
            IResponse::HTTP_CODE_SERVER_ERROR,
            IResponse::MESSAGE_SERVER_ERROR
        );
    }

    /**
     * @param Request     $request
     * @param Application $app
     * @return Response
     * @throws \InvalidArgumentException
     * @throws HttpException
     * @throws \LogicException
     */
    public function handleCreate(Request $request, Application $app): Response
    {
        /** @var SimpleResponse $response */
        $response = $app['response.default'];
        $this->parseRequest($request);

        if ($this->requestBody === null) {
            $this->throwInternalException();
        }

        $fileName = __DIR__ . '/../Schema/UserCreateRequest.json';
        if (!file_exists($fileName)) {
            $this->throwInternalException();
        }

        $violations = $app['json.validator']->validate(
            $this->requestBody,
            json_decode(file_get_contents($fileName))
        );

        if ($violations !== []) {
            $app['response.default']->addErrors($violations);
            $this->throwBadRequestException();
        }

        $id = $app['facades.user']->insertUser((array)$this->requestBody);
        $this->requestBody->id = $id;

        $response->setResponseBody((array)$this->requestBody);
        $response->setStatusCode(IResponse::HTTP_CODE_CREATED);
        $response->headers->add(['Location' => $request->getBaseUrl() . '/customers/' . $id]);
        return $response->build();
    }
}
