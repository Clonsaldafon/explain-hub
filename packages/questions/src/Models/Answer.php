<?php

namespace Questions\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Users\Models\User;

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

    public function likes(): HasMany {
        return $this->hasMany(AnswerLike::class);
    }

    public function isLikedBy($userId): bool {
        return $this->likes()->where('user_id', $userId)->exists();
    }

    public function toggleLike($userId): bool {
        if ($this->isLikedBy($userId)) {
            $this->likes()->where('user_id', $userId)->first()?->delete();
            $this->decrement('likes');
            return false;
        }
        else {
            $this->likes()->create(['user_id' => $userId]);
            $this->increment('likes');
            return true;
        }
    }

    public function incrementViews($sessionId = null): void {
        $viewed = session('viewed_answers', []);
        if (in_array($this->id, $viewed)) {
            return;
        }

        $viewed[] = $this->id;
        $viewed = array_slice($viewed, -50);
        session(['viewed_answers' => $viewed]);
        $this->increment('views');
    }
}
