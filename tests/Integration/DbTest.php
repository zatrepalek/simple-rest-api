<?php
declare(strict_types=1);

namespace Tests\Integration;

use Nette\Database\Connection;

abstract class DbTest extends BaseTest
{
    protected const DB_NAME_PREFIX = 't_';

    /** @var Connection */
    protected $connection;

    /** @var string */
    protected $dbName;

    public function setUp()
    {
        parent::setUp();
        $this->connection = $this->app['db'];
        $this->prepareDb();
    }

    public function tearDown()
    {
        $this->cleanDb();
    }

    /**
     * @param string $testMethodName
     * @return string
     */
    protected function randDbName(string $testMethodName): string
    {
        return self::DB_NAME_PREFIX . substr(md5($testMethodName), 0, 10);
    }

    protected function prepareDb(): void
    {
        $this->dbName = $this->randDbName(microtime(true) . $this->getName());
        $this->connection->query(sprintf('CREATE DATABASE `%s` COLLATE \'utf8_general_ci\'', $this->dbName));
        $this->connection->query(sprintf('USE `%s`', $this->dbName));
        $this->connection->query(file_get_contents(__DIR__ . '/../database/structure.sql'));
    }

    protected function cleanDb(): void
    {
        $this->connection->query(sprintf('DROP DATABASE `%s`', $this->dbName));
    }
}
