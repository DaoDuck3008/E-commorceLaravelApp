<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Productversion extends Model
{
    /**
    * The primary key for the model.
    * 
    * @var string
    */
   protected $primaryKey = 'VersionID';

   public $timestamps = false;


   /**
    * @var array
    */
   protected $fillable = ['ProductID', 'VersionName', 'Price'];

   /**
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
   public function product()
   {
       return $this->belongsTo('App\Models\Product', 'ProductID', 'ProductID');
   }

   public function cartitems()
    {
        return $this->hasMany('App\Models\Cartitem','VersionID','VersionID');
    }
}
