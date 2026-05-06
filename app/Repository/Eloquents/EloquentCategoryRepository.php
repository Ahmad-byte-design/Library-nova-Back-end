<?php

namespace App\Repository\Eloquents;

use App\Enum\GoogleDriveFolder;
use App\Models\Category;
use App\Repository\Interfaces\CategoryRepositoryInterface;
use App\Services\GoogleDriveService;

class EloquentCategoryRepository implements CategoryRepositoryInterface
{
    protected $model;

    protected $driveService;

    /**
     * Create a new class instance.
     */
    public function __construct(Category $model, GoogleDriveService $driveService)
    {
        $this->model = $model;
        $this->driveService = $driveService;
    }

    public function all($page )
    {
        return $this->model->paginate(10 ,["*"] ,"page" , $page);
    }

    public function find($id)
    {
        return $this->model->find($id);

    }

    public function create($data)
    {

        $iconFile = $data['icon'] ?? null;

        if ($iconFile) {
            $data['icon'] = $this->driveService->uploadFile($iconFile, GoogleDriveFolder::ICONS);
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

        $iconFile = $data['icon'] ?? null;

        if ($iconFile) {

            if ($model->icon && !str_starts_with($model->icon, 'http')) {
                $this->driveService->deleteFile($model->icon);
            }

            $data['icon'] = $this->driveService->uploadFile($iconFile, GoogleDriveFolder::ICONS);
        }

        return $model->update($data) ? $model : null;
    }

    public function destroy($id)
    {

        $model = $this->model->find($id);
        if (! $model) {
            return false;
        }

        if ($model->icon && !str_starts_with($model->icon, 'http')) {
            $this->driveService->deleteFile($model->icon);
        }

        return $model->delete();
    }
}
