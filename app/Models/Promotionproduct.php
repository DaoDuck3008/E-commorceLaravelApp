<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $PromotionID
 * @property integer $ProductID
 * @property Product $product
 * @property Promotion $promotion
 */
class Promotionproduct extends Model
{
    /**
     * @var array
     */
    protected $fillable = [];

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
    public function promotion()
    {
        return $this->belongsTo('App\Models\Promotion', 'PromotionID', 'PromotionID');
    }
}
