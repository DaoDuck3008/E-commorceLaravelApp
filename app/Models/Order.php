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

    public $timestamps = false;
    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'OrderID';

    protected $casts = [
        'OrderDate' => 'datetime',
        'PaymentDate' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * @var array
     */
    protected $fillable = ['UserID', 'OrderDate', 'TotalAmount', 'STATUS', 'ShippingAddress', 'PaymentMethod','Description','CancelReason'];

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

    public function getTotalRevenue(){
        return self::where('STATUS', 'Completed')->sum('TotalAmount');
    }


    public static function getTodayRevenue()
    {
        return self::whereDate('OrderDate', today())
                  ->where('STATUS', 'Completed') 
                  ->sum('TotalAmount');
    }
}
