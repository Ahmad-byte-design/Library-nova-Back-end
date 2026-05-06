<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Book extends Model
{
    //
    use HasFactory;
    protected $guarded = [];




    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function reviews(){
        return $this->hasMany(Review::class);
    }

    public function author(){
        return $this->belongsTo(Author::class);
    }


    public function saves(){
        return $this->belongsTo(User::class , "book_user_saves");
    }

    public function favorites(){
        return $this->belongsTo(User::class , "book_user_favorites");
    }

    public function getImageUrlAttribute()
    {
        if (str_starts_with($this->image, 'http')) {
            return $this->image;
        }
        return app(\App\Services\GoogleDriveService::class)->getFileUrl($this->image);
    }

    public function getBookUploadUrlAttribute()
    {
        if (str_starts_with($this->book_upload, 'http')) {
            return $this->book_upload;
        }
        return app(\App\Services\GoogleDriveService::class)->getFileUrl($this->book_upload);
    }

}
