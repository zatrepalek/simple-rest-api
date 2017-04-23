<?php
declare(strict_types=1);

namespace Tests\Integration;

use UserApi\Response\IResponse;

final class UserListTest extends DbTest
{
    public function setUp()
    {
        parent::setUp();
        $this->connection->query('
            INSERT INTO users (`id`, `name`, `email`, `phone`)
            VALUES (1, "Carl Mars", "john@example.com", 123456789),
            (3, "Bruno Fake", "john@example.com", 123456789)
        ');
    }

    public function testGetUser()
    {
        $client = $this->createClient();
        $client->request('GET', '/users');

        $this->assertEquals(IResponse::HTTP_CODE_OK, $client->getResponse()->getStatusCode());
        $this->assertCount(2, json_decode($client->getResponse()->getContent()));
    }
}
