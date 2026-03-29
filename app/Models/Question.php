<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'author_id',
        'title',
        'content',
        'status',
        'views',
        'likes',
    ];

    protected $casts = [
        'likes' => 'integer',
        'views' => 'integer',
    ];

    public function author() {
        return $this->belongsTo(User::class, 'author_id');
    }
    public function tags() {
        return $this->belongsToMany(Tag::class);
    }

    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    public function scopeOnModerate($query)
    {
        return $query->where('status', 'on_moderate');
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeRejected($query) {
        return $query->where('status', 'rejected');
    }

    public function incrementLikes() {
        $this->increment('likes');
    }

    public function incrementViews() {
        $this->increment('views');
    }
}
