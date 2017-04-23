<?php
declare(strict_types=1);

namespace Tests\Integration;

use UserApi\Response\IResponse;

final class UserUpdateTest extends DbTest
{
    public function setUp()
    {
        parent::setUp();
        $this->connection->query('INSERT INTO users (`id`, `name`, `email`, `phone`) VALUES (11, "John Doe", "john@example.com", 123456789)');
    }

    public function testUpdateUserOk()
    {
        $client = $this->createClient();
        $client->request('PATCH', '/users/11', [], [], BaseTest::HEADER_CONTENT_TYPE, json_encode(['name' => 'Marco Dust']));

        $this->assertEquals(IResponse::HTTP_CODE_OK, $client->getResponse()->getStatusCode());
    }

    public function testUpdateUserInvalidRequest()
    {
        $client = $this->createClient();
        $client->request('PATCH', '/users/11', [], [], BaseTest::HEADER_CONTENT_TYPE, json_encode(['foo' => 'bar']));

        $this->assertEquals(IResponse::HTTP_CODE_BAD_REQUEST, $client->getResponse()->getStatusCode());
    }
}
