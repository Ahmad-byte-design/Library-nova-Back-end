<?php

namespace App\Repository\Eloquents;

use App\Models\User;
use App\Repository\Interfaces\UsersRepositoryInterface;

class EloquentUserRepository implements UsersRepositoryInterface
{
    protected $model;

    /**
     * Create a new class instance.
     */
    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function all($page =1)
    {
       return $this->model->paginate(10,["*"],"page",$page);
    }

    public function find($id)
    {
        return $this->model->find($id);
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

    public function destroy($id) :bool
    {
        $model = $this->model->find($id);
        if(!$model)return false;
        return $model->delete();

    }

    public function findByEmail($email)
    {

        return $this->model->where("email",$email)->first() ?? null;
    }
}
