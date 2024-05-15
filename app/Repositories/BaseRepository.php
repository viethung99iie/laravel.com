<?php

namespace App\Repositories;

use App\Repositories\Interfaces\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

/**
 * Class UserService
 * @package App\Services
 */
class BaseRepository implements BaseRepositoryInterface
{
    protected $model;

    public function __construct(
        Model $model
    ) {
        $this->model = $model;
    }
    public function paginate(
        array $columns = ['*'],
        array $conditions = [],
        int $perpage = 20,
        array $extend = [],
        array $orderBy = ['id', 'desc'],
        array $join = [],
        array $relations = [],
        array $rawQuery = []
    ) {
        $query = $this->model->select($columns);
        return $query->keyword($conditions['keywords'] ?? null)
            ->publish($conditions['publish'] ?? null)
            ->relationCount($relations ?? null)
            ->customWhere($conditions['where'] ?? null)
            ->customWhereRaw($rawQuery ?? null)
            ->customJoin($join ?? null)
            ->customGroupBy($extend['groupBy'] ?? null)
            ->customOrderBy($orderBy ?? null)
            ->paginate($perpage)
            ->withQueryString();
    }
    public function create(array $payload = [])
    {
        $model = $this->model->create($payload);
        return $model->fresh();
    }
    public function update(int $id = 0, array $payload = [])
    {
        $model = $this->findById($id);
        return $model->update($payload);
    }
    public function findByCondition($condition = [], array $payload = [])
    {
        $query = $this->model->newQuery();
        foreach ($condition as $key => $val) {
            $query->where($val[0], $val[1], $val[2]);
        }
        return $query->first();
    }
    public function updateByWhereIn(
        String $whereInField = '',
        array $whereIn = [],
        array $payload = []
    ) {
        return $this->model->whereIn($whereInField, $whereIn)->update($payload);
    }
    public function updateByWhere($condition = [], array $payload = [])
    {
        $query = $this->model->newQuery();
        foreach ($condition as $key => $val) {
            $query->where($val[0], $val[1], $val[2]);
        }
        return $query->update($payload);
    }
    public function forceDelete($id)
    {
        return $this->findById($id)->forceDelete();
    }
    public function forceDeleteByCondition(array $condition = [])
    {
        $query = $this->model->newQuery();
        foreach ($condition as $key => $val) {
            $query->where($val[0], $val[1], $val[2]);
        }
        return $query->forceDelete();
    }
    public function delete(int $id = 0)
    {
        return $this->findById($id)->delete();
    }
    public function all()
    {
        return $this->model->all();
    }
    public function findById(
        int $modelId,
        array $columns = ['*'],
        array $relations = [],
    ) {
        return $this->model->select($columns)->with($relations)->findOrFail($modelId);
    }

    public function createPivot($model, array $payload = [], string $relation = null)
    {
        return $model->{$relation}()->attach($model->id, $payload);
    }
}
