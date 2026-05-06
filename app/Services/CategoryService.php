<?php

namespace App\Services;

use App\Repository\Interfaces\CategoryRepositoryInterface;
use App\Services\CacheService;
use Exception;

class CategoryService
{
    protected $categoryRepo;

    protected $cacheService;

    /**
     * Create a new class instance.
     */
    public function __construct(CategoryRepositoryInterface $categoryRepo, CacheService $cacheService)
    {
        $this->categoryRepo = $categoryRepo;
        $this->cacheService = $cacheService;

        //
    }

    public function getAllCategories(int $page = 1)
    {

        $cacheKey = "categories_page_{$page}";
        $ttl = 3600;

        // return $this->cacheService->remember($cacheKey, function () use ($page) {
            $categories = $this->categoryRepo->all($page);
            if (! $categories) {
                return null;
            }

            return $categories;
        // }, $ttl, 'categories');
    }

    public function getCategoryById($id)
    {
        try {

            $cacheKey = "category_{$id}";
            $ttl = 3600;

            // return $this->cacheService->remember($cacheKey, function () use ($id) {
                $category = $this->categoryRepo->find($id);
                if (! $category) {
                    return null;
                }

                return $category;
            // }, $ttl, 'categories');
        } catch (Exception $e) {
            throw new Exception('Registration failed: '.$e->getMessage());
        }
    }

    public function addCategory($data)
    {
        try {
            $category = $this->categoryRepo->create($data);
            if (! $category) {
                throw new Exception('the category has been field to add it !');
            }

            // $this->cacheService->flushTags('categories');

            return $category;
        } catch (Exception $e) {
            throw new Exception('Registration failed: '.$e->getMessage());
        }
    }

    public function updateCategory($id, $data)
    {
        try {
            $category = $this->categoryRepo->update($id, $data);
            if (! $category) {
                throw new Exception('the category has been field to update it !');
            }
            // $this->cacheService->flushTags('categories');

            return $category;
        } catch (Exception $e) {
            throw new Exception('Registration failed: '.$e->getMessage());
        }
    }

    public function deleteCategory($id)
    {
        try {
            $category = $this->categoryRepo->destroy($id);
            if (! $category) {
                throw new Exception('the category has been field to delete it !');
            }
            // $this->cacheService->flushTags('categories');

            return $category;
        } catch (Exception $e) {
            throw new Exception('Registration failed: '.$e->getMessage());
        }
    }
}
