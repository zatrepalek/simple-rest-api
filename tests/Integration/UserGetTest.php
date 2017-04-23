<?php
declare(strict_types=1);

namespace Tests\Integration;

use UserApi\Response\AbstractResponse;

final class UserGetTest extends DbTest
{
    public function setUp()
    {
        parent::setUp();
        $this->connection->query('INSERT INTO users (`id`, `name`, `email`, `phone`) VALUES (11, "John Doe", "john@example.com", 123456789)');
    }

    public function testGetUser()
    {
        $client = $this->createClient();
        $client->request('GET', '/users/11');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
