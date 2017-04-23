<?php
declare(strict_types=1);

namespace Tests\Integration;

use UserApi\Response\IResponse;

class NotFoundTest extends BaseTest
{
    public function testNotFound()
    {
        $client = $this->createClient();
        $client->request('GET', '/');

        $this->assertEquals(IResponse::HTTP_CODE_NOT_FOUND, $client->getResponse()->getStatusCode());
    }
}
