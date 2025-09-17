<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $PromotionID
 * @property string $Title
 * @property string $Description
 * @property float $DiscountPercent
 * @property string $StartDate
 * @property string $EndDate
 * @property Product[] $products
 */
class Promotion extends Model
{
    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'PromotionID';
    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = ['Title', 'Description', 'DiscountPercent', 'StartDate', 'EndDate', 'ImgURL'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function products()
    {
        return $this->belongsToMany('App\Models\Product', 'promotionproducts', 'PromotionID', 'ProductID');
    }
}
