<?php

namespace Questions\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Users\Models\User;

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

    public function author(): BelongsTo {
        return $this->belongsTo(User::class, 'author_id');
    }
    public function tags(): BelongsToMany {
        return $this->belongsToMany(Tag::class);
    }

    public function scopeDraft($query): Builder {
        return $query->where('status', 'draft');
    }

    public function scopeOnModerate($query): Builder {
        return $query->where('status', 'on_moderate');
    }

    public function scopePublished($query): Builder {
        return $query->where('status', 'published');
    }

    public function scopeRejected($query): Builder {
        return $query->where('status', 'rejected');
    }

    public function likes(): HasMany {
        return $this->hasMany(QuestionLike::class);
    }

    public function isLikedBy($user_id): bool {
        return $this->likes()->where('user_id', $user_id)->exists();
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

    public function incrementViews(): void {
        $viewed = session('viewed_questions', []);
        if (in_array($this->id, $viewed)) {
            return;
        }

        $viewed[] = $this->id;
        $viewed = array_slice($viewed, -50);
        session(['viewed_questions' => $viewed]);
        $this->increment('views');
    }
}
