<?php

namespace App;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use Sluggable;

    /**
     * @var array
     */
    protected $fillable = ['user_id', 'title', 'slug', 'description'];

    /**
     * @return mixed
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Returns the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title',
            ],
        ];
    }

    /**
     * Returns the user belongs to the post.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
