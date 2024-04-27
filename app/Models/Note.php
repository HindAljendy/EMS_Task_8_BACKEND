<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;

    protected $fillable = [
        'note',
    ];

    /* The relation Morph */
    public function noteable(){
        return $this->morphTo();
    }

}
