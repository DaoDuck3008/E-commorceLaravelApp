<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $OrderItemID
 * @property integer $OrderID
 * @property integer $ProductID
 * @property integer $Quantity
 * @property float $Price
 * @property Product $product
 * @property Order $order
 */
class Orderitem extends Model
{
    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'OrderItemID';

    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = ['OrderID', 'ProductID', 'Quantity', 'Price','VersionID','ColorID'];

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
    public function order()
    {
        return $this->belongsTo('App\Models\Order', 'OrderID', 'OrderID');
    }

    public function version()
    {
        return $this->belongsTo('App\Models\Productversion', 'VersionID', 'VersionID');
    }

    public function color()
    {
        return $this->belongsTo('App\Models\Productcolor', 'ColorID', 'ColorID');
    }
}
