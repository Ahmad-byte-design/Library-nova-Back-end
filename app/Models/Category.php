<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //
    use HasFactory;
    protected $guarded = [];

    public function books(){
        return $this->hasMany(Book::class);
    }

    public function getIconUrlAttribute()
    {
        if (str_starts_with($this->icon, 'http')) {
            return $this->icon;
        }
        return app(\App\Services\GoogleDriveService::class)->getFileUrl($this->icon);
    }
}
