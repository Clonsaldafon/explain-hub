<?php

namespace Questions\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = [
        'name',
        'color',
    ];

    public function questions() {
        return $this->belongsToMany(Question::class);
    }
}
