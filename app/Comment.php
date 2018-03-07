<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    /**
     * Fillable array for mass assignment.
     * @var array
     */
    protected $fillable = ['user_id', 'post_id', 'body'];

    /**
     * Get User information of the comment
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
