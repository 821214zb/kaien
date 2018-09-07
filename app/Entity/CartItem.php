<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'cart_item';
    protected $primaryKey = 'id';

//    public $timestamps = false;
}
