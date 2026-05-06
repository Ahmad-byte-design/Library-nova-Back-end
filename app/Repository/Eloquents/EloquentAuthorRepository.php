<?php

namespace App\Repository\Eloquents;

use App\Models\Author;
use App\Repository\Interfaces\AuthorRepositoryInterface;

class EloquentAuthorRepository implements AuthorRepositoryInterface
{
    protected $model;
    /**
     * Create a new class instance.
     */
    public function __construct( Author $model )
    {
        $this->model = $model;
    }

    public function all($page = 1)
    {
        return $this->model->paginate(10 , ["*"] , "page" ,$page );
    }

    public function find($id)
    {
        return $this->model->with(["books"])->find($id);
    }

    public function create($data)
    {

        $model = $this->model->create($data);
        return $model ? :null;
    }

    public function update($id, $data)
    {
             $model = $this->model->find($id);

        if (! $model) return null;

        return $model->update($data) ? $model : null ;

    }

    public function destroy($id)
    {
       $model = $this->model->find($id);
        if(!$model)return false;
        return $model->delete();
    }
}
