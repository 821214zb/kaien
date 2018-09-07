<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'member';
    protected $primaryKey = 'id';

//    public $timestamps = false;
}
