<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, HasFactory;

    protected $fillable = [
        'name', 'email', 'role', 'rating', 'password', 'is_blocked',
    ];

    protected $casts = [
        'rating' => 'integer',
        'is_blocked' => 'boolean',
    ];

    protected $hidden = [
        'password',
    ];

    public function questions() {
        return $this->hasMany(Question::class, 'author_id');
    }

    public function answers() {
        return $this->hasMany(Answer::class, 'author_id');
    }

    public function isAdmin() {
        return $this->role === 'admin';
    }

    public function isModerator() {
        return in_array($this->role, ['moderator', 'admin']);
    }

    public function isEditor() {
        return in_array($this->role, ['editor', 'moderator', 'admin']);
    }

    public function isUser() {
        return $this->role === 'user';
    }


}
