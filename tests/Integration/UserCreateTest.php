<?php
declare(strict_types=1);

namespace Tests\Integration;

use UserApi\Response\IResponse;

final class UserCreateTest extends DbTest
{
    private $user = [
        'name' => 'John Doe',
        'email' => 'test@example.com',
        'phone' => 123456789,
    ];

    public function testCreateUserOk()
    {
        $client = $this->createClient();
        $client->request('POST', '/users', [], [], BaseTest::HEADER_CONTENT_TYPE, json_encode($this->user));

        $this->assertEquals(IResponse::HTTP_CODE_CREATED, $client->getResponse()->getStatusCode());
    }

    public function testCreateUserInvalidName()
    {
        $client = $this->createClient();
        $this->user['name'] = 123;
        $client->request('POST', '/users', [], [], BaseTest::HEADER_CONTENT_TYPE, json_encode($this->user));

        $this->assertEquals(IResponse::HTTP_CODE_BAD_REQUEST, $client->getResponse()->getStatusCode());
    }

    public function testCreateUserInvalidEmail()
    {
        $client = $this->createClient();
        $this->user['email'] = 123;
        $client->request('POST', '/users', [], [], BaseTest::HEADER_CONTENT_TYPE, json_encode($this->user));

        $this->assertEquals(IResponse::HTTP_CODE_BAD_REQUEST, $client->getResponse()->getStatusCode());
    }

    public function testCreateUserInvalidPhone()
    {
        $client = $this->createClient();
        $this->user['phone'] = 123;
        $client->request('POST', '/users', [], [], BaseTest::HEADER_CONTENT_TYPE, json_encode($this->user));

        $this->assertEquals(IResponse::HTTP_CODE_BAD_REQUEST, $client->getResponse()->getStatusCode());
    }
}
