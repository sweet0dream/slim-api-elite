<?php

namespace App\Repository;

use App\Model\Db;
use Exception;
use MysqliDb;

abstract class AbstractRepository
{
    private MysqliDb $connect;
    public function __construct(
        private readonly string $modelClass,
    )
    {
        $this->connect = (new Db())->connect();
    }

    /**
     * @throws Exception
     */
    protected function get(
        string $model,
        ?array $where = null,
        ?array $orderBy = null
    ): array|string
    {
        if (!is_null($where)) {
            foreach ($where as $key => $value) {
                $this->connect->where($key, $value);
            }
        }
        if (!is_null($orderBy)) {
            foreach ($orderBy as $key => $value) {
                $this->connect->orderBy($key, $value);
            }
        }

        return $this->connect->get($model);
    }

    /**
     * @throws Exception
     */
    public function findBy(array $criteria, array $orderBy = []): array
    {
        foreach ($criteria as $key => $value) {
            $this->connect->where($key, $value);
        }
        if (!empty($orderBy)) {
            foreach ($orderBy as $key => $value) {
                $this->connect->orderBy($key, $value);
            }
        }
        return $this->get($this->modelClass);
    }

    /**
     * @throws Exception
     */
    public function findOne(int $id): ?array
    {
        return $this->get($this->modelClass, ['id' => $id])[0] ?? null;
    }

    /**
     * @throws Exception
     */
    public function findOneBy(array $criteria): ?array
    {
        foreach ($criteria as $key => $value) {
            $this->connect->where($key, $value);
        }

        return $this->get($this->modelClass)[0] ?? null;
    }

    /**
     * @throws Exception
     */
    public function updateById(int $id, array $data): array
    {
        $this->connect->where('id', $id)->update($this->modelClass, $data);

        return $this->findOneBy(['id' => $id]);
    }

    /**
     * @throws Exception
     */
    public function insert(array $data): array
    {
        $this->connect->insert($this->modelClass, $data);

        return $this->findOneBy(['id' => $this->connect->getInsertId()]);
    }

    /**
     * @throws Exception
     */
    public function deleteById(int $id): bool
    {
        return $this->connect->where('id', $id)->delete($this->modelClass);
    }
}