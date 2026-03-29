<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'author_id',
        'question_id',
        'status',
        'answer',
        'likes',
        'views',
    ];

    protected $casts = [
        'answer' => 'array',
        'likes' => 'integer',
        'views' => 'integer',
    ];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function incrementLikes(): void
    {
        $this->increment('likes');
    }

    public function incrementViews(): void {
        $this->increment('views');
    }
}
