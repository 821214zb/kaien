<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'product_image';
    protected $primaryKey = 'id';

    public $timestamps = false;
}
