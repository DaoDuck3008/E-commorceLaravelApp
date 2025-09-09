<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $OrderID
 * @property integer $UserID
 * @property string $OrderDate
 * @property float $TotalAmount
 * @property string $STATUS
 * @property string $ShippingAddress
 * @property string $PaymentMethod
 * @property Orderitem[] $orderitems
 * @property User $user
 * @property Payment[] $payments
 */
class Order extends Model
{
    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'OrderID';

    /**
     * @var array
     */
    protected $fillable = ['UserID', 'OrderDate', 'TotalAmount', 'STATUS', 'ShippingAddress', 'PaymentMethod'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orderitems()
    {
        return $this->hasMany('App\Models\Orderitem', 'OrderID', 'OrderID');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'UserID', 'UserID');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function payments()
    {
        return $this->hasMany('App\Models\Payment', 'OrderID', 'OrderID');
    }
}
