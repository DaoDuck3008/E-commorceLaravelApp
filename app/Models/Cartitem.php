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
    
    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = ['CartID', 'ProductID', 'Quantity','VersionID','ColorID'];

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

    public function version()
    {
        return $this->belongsTo('App\Models\Productversion','VersionID','VersionID');
    }

    public function color()
    {
        return $this->belongsTo('App\Models\Productcolor','ColorID','ColorID');
    }

    /**
     * Lấy giá áp dụng cho item (ưu tiên giá từ version nếu có)
     */
    public function getPriceAttribute()
    {
        if ($this->version && $this->version->Price) {
            return $this->version->Price;
        }
        
        return $this->product->Price;
    }
    
    /**
     * Tính tổng tiền cho item = giá * số lượng
     */
    public function getTotalAttribute()
    {
        return $this->price * $this->Quantity;
    }
}
