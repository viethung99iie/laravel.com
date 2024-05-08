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
    protected $model ;

    public function __construct(
        Model $model
    ){
        $this->model = $model;
    }
    public function paginate(
        array $columns = ['*'],
        array $conditions = [],
        int $perpage= 20,
        array $orderBy = ['id','desc'],
        array $joins = [],
        array $relations = [],
    ){
        $query = $this->model->select($columns)->where(function($query) use ($conditions){
            if(isset($conditions['keywords']) && !empty($conditions['keywords'])){
                $query->where('name','like','%'.$conditions['keywords'].'%');
            }
            if(isset($conditions['publish'])  && $conditions['publish']>0){
                $query->where('publish','=',$conditions['publish']);
            }
        });
        if(isset($relations)  && $relations){
            foreach($relations as $relation){
                $query->withCount($relation);
            }
        }
        if(isset($joins) && is_array($joins) && count($joins)) {
            foreach($joins as $key => $val){
            $query->join($val[0], $val[1], $val[2], $val[3]);
            }
        }
        if(isset($orderBy) && is_array($orderBy) && count($orderBy)) {
            foreach($orderBy as $key => $val){
            $query->orderBy($val[0], $val[1]);
            }
        }
        return $query->paginate($perpage)->withQueryString();
    }
    public function create(array $payload = []){
        $model=  $this->model->create($payload);
        return $model->fresh();
    }
    public function update(int $id = 0, array $payload = []){
        $model = $this->findById($id);
        return $model->update($payload);
    }
    public function updateByWhereIn(
        String $whereInField = '',
        array $whereIn = [],
        array $payload = []
    ){
        return $this->model->whereIn($whereInField,$whereIn)->update($payload);
    }
    public function forceDelete($id){
        return $this->findById($id)->forceDelete();
    }
    public function delete(int $id = 0){
        return $this->findById($id)->delete();
    }
    public function all(){
        return $this->model->all();
    }
    public function findById(
        int $modelId,
        array $columns = ['*'],
        array $relations = [],
    ){
        return $this->model->select($columns)->with($relations)->findOrFail($modelId);
    }

    public function createPivot($model, array $payload = [],string $relation = null){
        return $model->$relation()->attach($model->id, $payload);

    }
}
