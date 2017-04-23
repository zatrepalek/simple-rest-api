<?php
declare(strict_types=1);

namespace Tests\Integration;

use UserApi\Response\IResponse;

final class UserDeleteTest extends DbTest
{
    public function setUp()
    {
        parent::setUp();
        $this->connection->query('INSERT INTO users (`name`, `email`, `phone`) VALUES ("John Doe", "john@example.com", 123456789)');
    }

    public function testDeleteUserOk()
    {
        $client = $this->createClient();
        $client->request('DELETE', '/users/1');

        $this->assertEquals(IResponse::HTTP_CODE_OK, $client->getResponse()->getStatusCode());
    }
}
