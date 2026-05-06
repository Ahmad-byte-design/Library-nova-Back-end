<?php

namespace App\Services;

use App\Models\User;

class FavoriteService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }



    public function addFavorite(User $user , int $bookId){
        $user->favorites()->attach($bookId);
        return $user->favorites;

    }

    public function removeFavorite(User $user , int $bookId){
        $user->favorites()->detach($bookId);
        return true;
    }
}
