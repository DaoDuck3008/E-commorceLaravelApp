<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $ImgID
 * @property integer $ProductID
 * @property string $ImgURL
 * @property Product $product
 */
class Productimg extends Model
{
    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'ImgID';

    public $timestamps = false;


    /**
     * @var array
     */
    protected $fillable = ['ProductID', 'ImgURL'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo('App\Models\Product', 'ProductID', 'ProductID');
    }
}
