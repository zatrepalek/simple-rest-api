<?php
declare(strict_types=1);

namespace UserApi\Response;

use Symfony\Component\HttpFoundation\Response;

interface IResponse
{
    const HTTP_CODE_OK = 200;
    const HTTP_CODE_CREATED = 201;

    const HTTP_CODE_BAD_REQUEST = 400;
    const MESSAGE_BAD_REQUEST = 'Bad request.';
    const HTTP_CODE_NOT_FOUND = 404;

    const HTTP_CODE_SERVER_ERROR = 500;
    const MESSAGE_SERVER_ERROR = 'Internal server error.';

    /**
     * @param string $key
     * @param mixed  $value
     * @return mixed
     */
    public function set(string $key, mixed $value);

    /**
     * @param string $message
     * @return mixed
     */
    public function addError(string $message);

    /**
     * @return Response
     */
    public function build() : Response;
}
