<?php
declare(strict_types=1);

namespace Tests\Integration;

use UserApi\Response\IResponse;

final class UserReplaceTest extends DbTest
{
    public function setUp()
    {
        parent::setUp();
        $this->connection->query('INSERT INTO users (`id`, `name`, `email`, `phone`) VALUES (11, "John Doe", "john@example.com", 123456789)');
    }

    public function testReplaceUserOk()
    {
        $client = $this->createClient();
        $client->request('PUT', '/users/11', [], [], BaseTest::HEADER_CONTENT_TYPE, json_encode(['name' => 'Benedict Foo', 'email' => 'benedict@example.com', 'phone' => 123123123])
        );

        $this->assertEquals(IResponse::HTTP_CODE_OK, $client->getResponse()->getStatusCode());
    }

    public function testReplaceUserInvalidRequest()
    {
        $client = $this->createClient();
        $client->request('PUT', '/users/11', [], [], BaseTest::HEADER_CONTENT_TYPE, json_encode(['foo' => 'bar']));

        $this->assertEquals(IResponse::HTTP_CODE_BAD_REQUEST, $client->getResponse()->getStatusCode());
    }
}
