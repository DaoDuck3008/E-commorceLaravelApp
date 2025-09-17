<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $PaymentID
 * @property integer $OrderID
 * @property string $PaymentDate
 * @property float $Amount
 * @property string $PaymentMethod
 * @property string $STATUS
 * @property Order $order
 */
class Payment extends Model
{
    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'PaymentID';

    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = ['OrderID', 'PaymentDate', 'Amount', 'PaymentMethod', 'STATUS'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order()
    {
        return $this->belongsTo('App\Models\Order', 'OrderID', 'OrderID');
    }
}
