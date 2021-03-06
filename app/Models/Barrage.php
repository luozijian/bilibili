<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barrage extends Model
{
    protected $fillable = ['user_id','content'];

    public static $rules = [
        'content' => 'required',
    ];

    /****  relationship ****/
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
