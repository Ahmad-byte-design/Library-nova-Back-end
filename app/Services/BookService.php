<?php

namespace App\Services;

use App\Repository\Interfaces\BookRepositoryInterface;
use Exception;
use Illuminate\Support\Collection;

class BookService
{
    protected $bookRepo;

    protected $cacheService;

    /**
     * Create a new class instance.
     */
    public function __construct(BookRepositoryInterface $bookRepo, CacheService $cacheService)
    {
        $this->bookRepo = $bookRepo;
        $this->cacheService = $cacheService;
    }

    public function getAllBooks(int $page = 1, int $per_page = 15)
    {

        $cacheKey = "books_page_{$page}_per_{$per_page}";
        $ttl = 3600; // time to left

        // $cached = $this->cacheService->remember($cacheKey, function () use ($page, $per_page) {
            $books = $this->bookRepo->all($page, $per_page);

            return $books;

        // }, $ttl, 'books');

        if (! $cached) {
            return null;
        }

        return $cached;

    }

    public function getBookById($id)
    {

        try {

            $cacheKey = "book_{$id}";
            $ttl = 3600;

            // return $this->cacheService->remember($cacheKey, function () use ($id) {
                $book = $this->bookRepo->find($id);
                if (! $book) {
                    return null;
                }

                return $book;
            // }, $ttl, 'books');

        } catch (Exception $e) {
            throw new Exception('Registration failed: '.$e->getMessage());
        }
    }

    public function addBook($data)
    {

        try {
            $book = $this->bookRepo->create($data);
            if (! $book) {
                throw new Exception('book not found');
            }

            // $this->cacheService->flushTags('books');

            return $book;
        } catch (Exception $e) {
            throw new Exception('Registration failed: '.$e->getMessage());
        }
    }

    public function updateBook($id, $data)
    {

        try {
            $book = $this->bookRepo->update($id, $data);
            if (! $book) {
                throw new Exception('book not found');
            }
            // $this->cacheService->flushTags('books');

            return $book;
        } catch (Exception $e) {
            throw new Exception('Registration failed: '.$e->getMessage());
        }

    }

    public function deleteBook($id)
    {
        try {
            $book = $this->bookRepo->destroy($id);

            if (! $book) {
                throw new Exception('book not found');
            }

            // $this->cacheService->flushTags('books');

            return true;
        } catch (Exception $e) {
            throw new Exception('Registration failed: '.$e->getMessage());
        }
    }
}
