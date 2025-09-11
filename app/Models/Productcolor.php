<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Productcolor extends Model
{
   /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'ColorID';

    public $timestamps = false;


    /**
     * @var array
     */
    protected $fillable = ['ProductID','Color', 'ImgURL'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo('App\Models\Product', 'ProductID', 'ProductID');
    }

    public function cartitems()
    {
        return $this->hasMany('App\Models\Cartitem','ColorID','ColorID');
    }
}
