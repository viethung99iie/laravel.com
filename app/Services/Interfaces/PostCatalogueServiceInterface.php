<?php

namespace App\Services\Interfaces;

/**
 * Interface PostServiceInterface
 * @package App\Services\Interfaces
 */
interface PostCatalogueServiceInterface
{
    public function paginate($request);
    public function create( $payload);
    public function update(int $id, $payload);
    public function delete( int $id);
    public function updateStatus($post);
    public function updateStatusAll($post);
}
