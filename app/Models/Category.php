<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'image',
        'parent_id'
    ];


    public function parent(){
        return $this->belongsTo(self::class, 'parent_id');
    }
}
