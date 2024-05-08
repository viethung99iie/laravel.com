<?php

namespace App\Repositories;

use App\Models\District;
use App\Repositories\Interfaces\DistrictRepositoryInterface;

/**
 * Class UserService
 * @package App\Services
 */
class DistrictRepository extends BaseRepository implements DistrictRepositoryInterface
{
    protected $model ;

    public function __construct(
        District $model
    ){
        $this->model = $model;
    }
    
}
