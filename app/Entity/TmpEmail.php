<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class TmpEmail extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'tmp_email';
    protected $primaryKey = 'id';

    public $timestamps = false;



   
}
