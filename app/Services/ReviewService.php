<?php

namespace App\Services;

use App\Repository\Interfaces\ReviewRepositoryInterface;
use Exception;

class ReviewService
{
    protected $reviewRepo;

    protected $cacheService;

    /**
     * Create a new class instance.
     */
    public function __construct(ReviewRepositoryInterface $reviewRepo, CacheService $cacheService)
    {
        $this->reviewRepo = $reviewRepo;
        $this->cacheService = $cacheService;

        //
    }

    public function getAllReviewsOfBook($book_id, int $page = 1)
    {
        try {

            $cacheKey = "reviews_page_{$page}";
            $ttl = 3600;

            // return $this->cacheService->remember($cacheKey, function () use ($book_id, $page) {
                $reviews = $this->reviewRepo->all($book_id, $page);
                if (! $reviews) {
                    return null;
                }

                return $reviews;
            // }, $ttl, 'reviews');
        } catch (Exception $e) {
            throw new Exception('Registration failed: '.$e->getMessage());
        }
    }

    public function addReview($data)
    {
        try {
            $review = $this->reviewRepo->create($data);
            if (! $review) {
                throw new Exception('field to get add the comments for this book');
            }

            // $this->cacheService->flushTags('reviews');

            return $review;
        } catch (Exception $e) {
            throw new Exception('Registration failed: '.$e->getMessage());
        }
    }

    public function updateReview($id, $data)
    {
        try {
            $review = $this->reviewRepo->update($id, $data);
            if (! $review) {
                throw new Exception('field to get update the comments for this book');
            }
            // $this->cacheService->flushTags('reviews');

            return $review;
        } catch (Exception $e) {
            throw new Exception('Registration failed: '.$e->getMessage());
        }
    }

    public function deleteReview($id)
    {
        try {
            $review = $this->reviewRepo->destroy($id);
            if (! $review) {
                throw new Exception('field to get delete the comments for this book');
            }

            // $this->cacheService->flushTags('reviews');

            return $review;
        } catch (Exception $e) {
            throw new Exception('Registration failed: '.$e->getMessage());
        }
    }
}
