<?php

namespace App\Services;

use App\Models\User;

class SaveService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function addSave(User $user ,int $bookId){
        $user->saves()->attach($bookId);
        return $user->saves;
    }



    public function removeSave(User $user ,int $bookId){
        $user->saves()->detach($bookId);
        return true;
    }


}
