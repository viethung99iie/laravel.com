<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;

/**
 * Class UserService
 * @package App\Services
 */
class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    protected $model ;

    public function __construct(
        User $model
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
        $query = $this->model->select($columns)->orderBy('id','desc')->where(function($query) use ($conditions){
            if(isset($conditions['keywords']) && !empty($conditions['keywords'])){
                $query->where('name','like','%'.$conditions['keywords'].'%')
                    ->orWhere('phone','like','%'.$conditions['keywords'].'%')
                    ->orWhere('email','like','%'.$conditions['keywords'].'%')
                    ->orWhere('address','like','%'.$conditions['keywords'].'%');
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
        if(!empty($joins)){
            $query = $query->join($joins);
        }
        return $query->paginate($perpage)->withQueryString();
    }
}
