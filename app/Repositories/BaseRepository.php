<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Exceptions\CustomException;
use App\Exceptions\RepositoryException;
use App\Enums\QueryEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Container\Container as App;
use Illuminate\Contracts\Container\BindingResolutionException;
use App\Repositories\Interfaces\BaseRepository as BaseRepositoryInterface;

abstract class BaseRepository implements BaseRepositoryInterface
{

    /**
     * @var App
     */
    private $app;

    /**
     * @var Model An instance of the Eloquent Model
     */
    protected $model;

    /**
     * BaseRepository constructor.
     * @param App $app
     * @throws RepositoryException
     * @throws BindingResolutionException
     */
    public function __construct(App $app)
    {
        $this->app = $app;
        $this->makeModel();
    }


    /**
     * @return mixed
     */
    public abstract function model();

    /**
     * @return Model|mixed
     * @throws RepositoryException
     * @throws BindingResolutionException
     */
    protected function makeModel()
    {
        $model = $this->app->make($this->model());
        if (!$model instanceof Model) {
            throw new RepositoryException(
                "Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model"
            );
        }
        return $this->model = $model;
    }


    /**
     * @inheritdoc
     */
    public function find($id)
    {
        return $this->model->find($id);
    }

    /**
     * @inheritDoc
     */
    public function findOrFail($id)
    {
        try {
            $query = $this->model->newQuery();

            return $query->findOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw CustomException::modelNotFound();
        }
    }

    /**
     * @inheritdoc
     */
    public function all()
    {
        return $this->model->orderBy(QueryEnum::DefaultOrderByColumn, QueryEnum::DescendingOrder)->get();
    }

    /**
     * @inheritdoc
     */
    public function allWithBuilder(): Builder
    {
        return $this->model->query();
    }

    /**
     * @inheritdoc
     */
    public function create($data)
    {
        $this->validate($data);
        $model = $this->model->create($data);

        return $model;
    }

    /**
     * @inheritdoc
     */
    public function update($model, $data)
    {
        $this->validate($data, true, $model->id);

        $model->update($data);

        return $model;
    }

    /**
     * @inheritdoc
     */
    public function destroy($model)
    {
        $deleted = $model->delete();
        return $deleted;
    }

    /**
     * Validate data
     * @param $data
     * @param bool $is_update
     * @param null $id
     * @throws ValidationException
     */
    protected function validate($data, $is_update = false, $id = null)
    {
        $rules = method_exists($this->model, 'rules') ? $this->model->rules($is_update, $id) : [];
        $messages = method_exists($this->model, 'messages') ? $this->model->messages($is_update, $id) : [];
        if ($rules && $messages) {
            $validator = Validator::make($data, $rules, $messages);
            if ($validator->fails()) {
                throw (new ValidationException)->setValidator($validator);
            }
        }
    }
}
