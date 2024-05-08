<?php

namespace App\Services\Interfaces;

/**
 * Interface UserServiceInterface
 * @package App\Services\Interfaces
 */
interface UserCatalogueServiceInterface
{
    public function paginate($request);
    public function create( $payload);
    public function update(int $id, $payload);
    public function delete( int $id);
    public function updateStatus($post);
    public function updateStatusAll($post);
}
