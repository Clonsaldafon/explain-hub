<?php

namespace Questions\Models;

use Illuminate\Database\Eloquent\Model;
use Users\Models\User;

class AnswerLike extends Model
{
    protected $fillable = [
        'answer_id',
        'user_id',
    ];

    public function answer() { return $this->belongsTo(Answer::class); }
    public function user() { return $this->belongsTo(User::class); }
}
