<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    protected $fillable = ['name', 'slug'];

    public function threads()
    {
        return $this->hasMany(Thread::class);
    }
}
