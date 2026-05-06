<?php

namespace App\Repository\Eloquents;

use App\Models\Review;
use App\Repository\Interfaces\ReviewRepositoryInterface;

class EloquentReviewRepository implements ReviewRepositoryInterface
{
    protected $model;

    /**
     * Create a new class instance.
     */
    public function __construct(Review $model)
    {
        //
        $this->model = $model;
    }

    public function all($id , $page = 1 )
    {
        return $this->model->where('book_id', $id)->paginate(15 , ["*"] , "page" , $page );

    }

    public function create($data)
    {

        $model = $this->model->create($data);

        return $model ?: null;
    }

    public function update($id, $data)
    {
        $model = $this->model->find($id);

        if (! $model) {
            return null;
        }

        return $model->update($data) ? $model : null;
    }

    public function destroy($id)
    {
        $model = $this->model->find($id);
        if (! $model) {
            return false;
        }

        return $model->delete();
    }
}
