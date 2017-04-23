<?php
declare(strict_types=1);

namespace UserApi\Response;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class SimpleResponse extends Response
{
    const DEFAULT_HEADERS = [
        'Content-Type' => 'application/json'
    ];

    const KEY_ERRORS = 'errors';

    /** @var array */
    protected $responseBody;

    /**
     * SimpleResponse constructor.
     * @param string $content
     * @param int    $status
     * @param array  $headers
     * @throws \InvalidArgumentException
     */
    public function __construct(string $content = '', int $status = 200, array $headers = [])
    {
        parent::__construct($content, $status, $headers === [] ? self::DEFAULT_HEADERS : $headers);
        $this->responseBody = [];
    }

    /**
     * @param array $responseBody
     */
    public function setResponseBody(array $responseBody): void
    {
        $this->responseBody = $responseBody;
    }

    /**
     * @param string $message
     */
    public function addError(string $message): void
    {
        if (!isset($this->responseBody[self::KEY_ERRORS])) {
            $this->responseBody[self::KEY_ERRORS] = [];
        }

        $this->responseBody[self::KEY_ERRORS][] = $message;
    }

    /**
     * @param array $errors
     */
    public function addErrors(array $errors): void
    {
        $this->responseBody[self::KEY_ERRORS][] = $errors;
    }

    /**
     * @return Response
     */
    public function build(): Response
    {
        return new JsonResponse($this->responseBody, $this->statusCode, $this->headers->all());
    }
}
