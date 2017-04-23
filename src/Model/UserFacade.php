<?php
declare(strict_types=1);

namespace UserApi\Model;

use Nette\Database\Connection;

final class UserFacade
{
    private const TABLE_USER = 'users';

    /** @var Connection */
    protected $connection;

    /**
     * UserFacade constructor.
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @param array $data
     * @return int
     */
    public function insertUser(array $data): int
    {
        $this->connection->query(
            sprintf('INSERT INTO `%s`', self::TABLE_USER),
            $data
        );

        return (int)$this->connection->getInsertId();
    }
}
