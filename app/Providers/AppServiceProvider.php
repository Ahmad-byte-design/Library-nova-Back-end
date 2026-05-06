<?php

namespace App\Providers;

use App\Repository\Eloquents\EloquentAuthorRepository;
use App\Repository\Eloquents\EloquentBookRepository;
use App\Repository\Eloquents\EloquentCategoryRepository;
use App\Repository\Eloquents\EloquentReviewRepository;
use App\Repository\Eloquents\EloquentUserRepository;
use App\Repository\Interfaces\AuthorRepositoryInterface;
use App\Repository\Interfaces\BookRepositoryInterface;
use App\Repository\Interfaces\CategoryRepositoryInterface;
use App\Repository\Interfaces\ReviewRepositoryInterface;
use App\Repository\Interfaces\UsersRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(AuthorRepositoryInterface::class , EloquentAuthorRepository::class);
        $this->app->bind(BookRepositoryInterface::class , EloquentBookRepository::class);
        $this->app->bind(CategoryRepositoryInterface::class , EloquentCategoryRepository::class);
        $this->app->bind(ReviewRepositoryInterface::class , EloquentReviewRepository::class);
        $this->app->bind(UsersRepositoryInterface::class , EloquentUserRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
