<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\models\User;
use App\models\Penemu;

class Likes extends Model
{
    use HasFactory;
    public $table = 'likes';
    protected $fillable = [
        'user_id','penemu_id'];


    function user(){
        return $this->belongsTo(User::class);
    }

    function penemu(){
        return $this->belongsTo(Penemu::class);
    }
}