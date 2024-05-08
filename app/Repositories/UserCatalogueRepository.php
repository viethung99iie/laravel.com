<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\UserCatalogue;
use App\Repositories\Interfaces\UserCatalogueRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;

/**
 * Class UserService
 * @package App\Services
 */
class UserCatalogueRepository extends BaseRepository implements UserCatalogueRepositoryInterface
{
    protected $model ;

    public function __construct(
        UserCatalogue $model
    ){
        $this->model = $model;
    }
}
