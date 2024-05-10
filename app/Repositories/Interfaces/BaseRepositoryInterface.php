<?php

namespace App\Repositories\Interfaces;

/**
 * Interface UserServiceInterface
 * @package App\Services\Interfaces
 */
interface BaseRepositoryInterface
{
    public function paginate(
        array $columns = ['*'],
        array $conditions = [],
        int $perpage = 20,
        array $extend = [],
        array $orderBy = ['id', 'desc'],
        array $joins = [],
        array $relations = [],
        array $whereRaw = []
    );
    public function all();
    public function create(array $payload);
    public function update(int $id, array $payload);
    public function delete(int $id = 0);
    public function forceDelete($id);
    public function findById(int $modelId, array $columns, array $relations);
    public function updateByWhereIn(String $whereInField = '', array $whereIn = [], array $payload = []);
    public function createPivot($model, array $payload = [], string $relation = null);
}
