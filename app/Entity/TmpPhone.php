<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class TmpPhone extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'tmp_phone';
    protected $primaryKey = 'id';

    public $timestamps = false;



   
}
