<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Avi extends Model
{
    protected $fillable = ['message', 'visibilite', 'user_id'];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
