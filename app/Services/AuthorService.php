<?php

namespace App\Services;

use App\Repository\Interfaces\AuthorRepositoryInterface;
use Exception;

class AuthorService
{
    protected $authorRepo;

    protected $cacheService;

    /**
     * Create a new class instance.
     */
    public function __construct(AuthorRepositoryInterface $authorRepo, CacheService $cacheService)
    {
        $this->authorRepo = $authorRepo;
        $this->cacheService = $cacheService;
    }

    public function getAllAuthors(int $page = 1)
    {
        $cacheKey = "authors_page_{$page}";
        $ttl = 3600;

        // return $this->cacheService->remember($cacheKey, function () use ($page) {
            return $this->authorRepo->all($page);
        // }, $ttl, 'authors');
    }

    public function getAuthorById($id)
    {

        try {

            $cacheKey = "author_{$id}";
            $ttl = 3600;

            // return $this->cacheService->remember($cacheKey, function () use ($id) {
                $author = $this->authorRepo->find($id);
                if (! $author) {
                    return null;
                }

                return $author;
            // }, $ttl, 'authors');

        } catch (Exception $e) {
            throw new Exception('Registration failed: '.$e->getMessage());
        }
    }

    public function addAuthor($data)
    {
        try {
            $author = $this->authorRepo->create($data);

            if (! $author) {
                throw new Exception('Failed to create author');
            }

            // $this->cacheService->flushTags('authors');

            return $author;
        } catch (Exception $e) {
            throw new Exception('Registration failed: '.$e->getMessage());
        }
    }

    public function updateAuthor($id, $data)
    {
        try {
            $author = $this->authorRepo->update($id, $data);

            if (! $author) {
                throw new Exception('Author not found or update failed');
            }

            // $this->cacheService->flushTags('authors');

            return $author;
        } catch (Exception $e) {
            throw new Exception('Registration failed: '.$e->getMessage());
        }
    }

    public function deleteAuthor($id)
    {
        try {
            $author = $this->authorRepo->destroy($id);

            if (! $author) {
                throw new Exception('Author not found or could not be deleted');
            }

            // $this->cacheService->flushTags('authors');

            return true;
        } catch (Exception $e) {
            throw new Exception('Registration failed: '.$e->getMessage());
        }
    }
}
