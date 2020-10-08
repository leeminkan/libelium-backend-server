<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Builder;

interface BaseRepository
{
    /**
     * Find data by id
     * @param int $id
     * @return $model
     */
    public function find($id);

    /**
     * Find data by id
     * @param $id
     * @return mixed
     */
    public function findOrFail($id);

    /**
     * Return a collection of all elements of the resource
     * @return Collection
     */
    public function all();

    /**
     * @return Builder
     */
    public function allWithBuilder(): Builder;

    /**
     * Create a resource
     * @param  $data
     * @return $model
     */
    public function create($data);

    /**
     * Update a resource
     * @param  $model
     * @param array $data
     * @return $model
     */
    public function update($model, $data);

    /**
     * Destroy a resource
     * @param  $model
     * @return bool
     */
    public function destroy($model);
}