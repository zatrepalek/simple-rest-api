<?php
declare(strict_types=1);

namespace UserApi\Model;

use Nette\Database\Connection;
use Nette\Database\ResultSet;
use Nette\Database\Row;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use UserApi\Response\IResponse;

final class UserFacade
{
    public const RESOURCE_COLUMNS = ['id', 'name', 'phone', 'email'];
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

    /**
     * @param int $id
     * @return Row
     * @throws NotFoundHttpException
     */
    public function getUser(int $id): Row
    {
        $result = $this->connection->query(
            sprintf('SELECT %s FROM `%s` WHERE id =?', implode(',', self::RESOURCE_COLUMNS), self::TABLE_USER),
            $id
        );

        if ($result->getRowCount() !== 1) {
            throw new NotFoundHttpException(IResponse::MESSAGE_NOT_FOUND);
        }

        return $result->fetch();
    }

    /**
     * @return ResultSet
     */
    public function getUsers(): ResultSet
    {
        return $this->connection->query(sprintf('SELECT %s FROM `%s`', implode(',', self::RESOURCE_COLUMNS), self::TABLE_USER));
    }

    /**
     * @param array $data
     * @param int   $id
     * @return array
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function updateUser(array $data, int $id): array
    {
        $result = $this->connection->query(
            sprintf('SELECT %s FROM `%s` WHERE id =?', implode(',', self::RESOURCE_COLUMNS), self::TABLE_USER),
            $id
        );

        if ($result->getRowCount() !== 1) {
            throw new NotFoundHttpException(IResponse::MESSAGE_NOT_FOUND);
        }
        $row = (array)$result->fetch();

        $this->connection->query(
            sprintf('UPDATE `%s` SET ? WHERE id=?', self::TABLE_USER),
            $data,
            $id
        );

        foreach ($data as $key => $value) {
            $row[$key] = $value;
        }

        return $row;
    }

    /**
     * @param int $id
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function deleteUser(int $id): void
    {
        $result = $this->connection->query(
            sprintf('DELETE FROM `%s` WHERE id=?', self::TABLE_USER),
            $id
        );

        if ($result->getRowCount() !== 1) {
            throw new NotFoundHttpException(IResponse::MESSAGE_NOT_FOUND);
        }
    }
}
