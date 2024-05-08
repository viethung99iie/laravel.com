<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\Language;
use App\Repositories\Interfaces\LanguageRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;

/**
 * Class UserService
 * @package App\Services
 */
class LanguageRepository extends BaseRepository implements LanguageRepositoryInterface
{
    protected $model ;

    public function __construct(
        Language $model
    ){
        $this->model = $model;
    }
}
