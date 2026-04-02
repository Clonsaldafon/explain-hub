<?php

namespace Questions\Models;

use Illuminate\Database\Eloquent\Model;
use Users\Models\User;

class QuestionLike extends Model
{
    protected $fillable = [
        'user_id',
        'question_id'
    ];

    public function user() { return $this->belongsTo(User::class); }
    public function question() { return $this->belongsTo(Question::class); }
}
