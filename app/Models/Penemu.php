<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Likes;
class Penemu extends Model
{
    use HasFactory;
    public $table = 'penemu';
    protected $fillable = [
        'title',
        'body',
        'author',
        'user_id',
        'image',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function likes()
    {
        return $this->hasMany(Likes::class);
    }
}