<?php

namespace App\Repositories;

use App\Models\Generate;
use App\Models\User;
use App\Repositories\Interfaces\GenerateRepositoryInterface;

/**
 * Class UserService
 * @package App\Services
 */
class GenerateRepository extends BaseRepository implements GenerateRepositoryInterface
{
    protected $model;

    public function __construct(
        Generate $model
    ) {
        $this->model = $model;
    }
}
