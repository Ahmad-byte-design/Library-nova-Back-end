<?php

namespace App\Repository\Eloquents;

use App\Enum\GoogleDriveFolder;
use App\Models\Book;
use App\Repository\Interfaces\BookRepositoryInterface;
use App\Services\GoogleDriveService;

class EloquentBookRepository implements BookRepositoryInterface
{
    protected $model;

    protected $driveService;

    /**
     * Create a new class instance.
     */
    public function __construct(Book $model, GoogleDriveService $driveService)
    {
        //
        $this->model = $model;
        $this->driveService = $driveService;
    }

    public function all($page = 1 ,$per_page = 1)
    {
        $query = Book::query();
        $paginator = $query->with(['author','category'])->paginate($per_page, ['*'], 'page', $page);
        return $paginator;
    }

    public function find($id)
    {
        return $this->model->with(['category', 'author'])->find($id);
    }

    public function create($data)
    {

        $bookFile = $data['book_upload'] ?? null;
        $coverFile = $data['image'] ?? null;

        if ($bookFile) {
            $data['book_upload'] = $this->driveService->uploadFile($bookFile, GoogleDriveFolder::BOOKS);
        }
        if ($coverFile) {
            $data['image'] = $this->driveService->uploadFile($coverFile, GoogleDriveFolder::COVERS);
        }

        $model = $this->model->create($data);

        return $model ?: null;

    }

    public function update($id, $data)
    {

        $model = $this->model->find($id);

        if (! $model) {
            return null;
        }

        $bookFile = $data['book_upload'] ?? null;
        $coverFile = $data['image'] ?? null;

        if ($bookFile) {
            if ($model->book_upload && !str_starts_with($model->book_upload, 'http')) {
                $this->driveService->deleteFile($model->book_upload);
            }
            $data['book_upload'] = $this->driveService->uploadFile($bookFile, GoogleDriveFolder::BOOKS);
        }

        if ($coverFile ) {
            if($model->image && !str_starts_with($model->image, 'http')){
                $this->driveService->deleteFile($model->image);
            }
            $data['image'] = $this->driveService->uploadFile($coverFile, GoogleDriveFolder::COVERS);
        }

        return $model->update($data) ? $model : null;

    }

    public function destroy($id)
    {

        $model = $this->model->find($id);
        if (! $model) {
            return false;
        }

        if ($model->book_upload && !str_starts_with($model->book_upload, 'http')) {
            $this->driveService->deleteFile($model->book_upload);
        }
        if ($model->image && !str_starts_with($model->image, 'http')) {
            $this->driveService->deleteFile($model->image);
        }

        return $model->delete();

    }
}
