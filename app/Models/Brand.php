<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $primaryKey = 'BrandID';

    public $timestamps = false;

    protected $fillable = ['BrandID', 'BrandName', 'CategoryID','Description'];

    public function categories()
    {
        return $this->belongsTo('App\Models\Category','CategoryID','CategoryID');
    }

    public function products()
    {
        return $this->hasMany('App\Models\Product', 'BrandID', 'BrandID');
    }
}
