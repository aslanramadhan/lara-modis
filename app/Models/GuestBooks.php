<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class GuestBooks extends Model
{
    /**
     * Model Config
     */
    protected $connection = 'mongodb';
    protected $collection = 'guest_books';
    protected $fillable = array('fullName', 'email', 'address', 'message');
}
