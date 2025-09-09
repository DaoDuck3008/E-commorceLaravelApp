<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $CartItemID
 * @property integer $CartID
 * @property integer $ProductID
 * @property integer $Quantity
 * @property Product $product
 * @property Cart $cart
 */
class Cartitem extends Model
{
    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'CartItemID';

    /**
     * @var array
     */
    protected $fillable = ['CartID', 'ProductID', 'Quantity'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo('App\Models\Product', 'ProductID', 'ProductID');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cart()
    {
        return $this->belongsTo('App\Models\Cart', 'CartID', 'CartID');
    }
}
