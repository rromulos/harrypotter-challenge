<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Character extends Model
{
    protected $table = 'characters';

    public $timestamps = true;
    protected $guarded = ['id'];
    protected $fillable = ['name','role','school','house','patronus'];
}
