<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Contact extends Model
{
    use SearchableTrait;
    protected $guarded = [];

    protected $searchable = [
        'columns' => [
            'contacts.name' => 10,
            'contacts.title' => 10,
        ]
    ];

    // start accessors
    public function getStatusAttribute($val)
    {
        return ($val == 1)? 'Read' : 'New';
    }
}
