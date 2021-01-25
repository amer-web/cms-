<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Post extends Model
{
    use Sluggable, SearchableTrait;
    protected $guarded = [];
    protected $searchable = [
        'columns' => [
            'posts.title' => 10
        ]
    ];
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }


    //start accessors//
    public function getStatusAttribute($val)
    {
       return $val == 1? 'Active' : 'InActive';
    }


    // start relations ship//
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function media()
    {
        return $this->hasMany(PostMedia::class);
    }
}
