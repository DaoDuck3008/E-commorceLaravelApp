<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $CategoryID
 * @property string $CategoryName
 * @property string $Description
 * @property Product[] $products
 */
class Category extends Model
{
    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'CategoryID';

    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = ['CategoryID','CategoryName', 'Description'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products()
    {
        return $this->hasMany('App\Models\Product', 'CategoryID', 'CategoryID');
    }

    public function brands()
    {
        return $this->hasMany('App\Models\Brand','CategoryID','CategoryID');
    }
}
