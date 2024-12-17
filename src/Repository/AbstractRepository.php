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

    protected function get(
        string $model,
        ?array $where = null,
        ?array $orderBy = null
    ): array|string
    {
        try {
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
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

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

    public function findOne(int $id): ?array
    {
        return $this->get($this->modelClass, ['id' => $id])[0] ?? null;
    }

    public function findOneBy(array $criteria): ?array
    {
        foreach ($criteria as $key => $value) {
            $this->connect->where($key, $value);
        }

        return $this->get($this->modelClass)[0] ?? null;
    }

    public function updateById(int $id, array $data): array
    {
        $this->connect->where('id', $id)->update($this->modelClass, $data);

        return $this->findOneBy(['id' => $id]);
    }

    public function insert(array $data): array
    {
        $this->connect->insert($this->modelClass, $data);

        return $this->findOneBy(['id' => $this->connect->getInsertId()]);
    }

    public function deleteById(int $id): bool
    {
        return $this->connect->where('id', $id)->delete($this->modelClass);
    }
}