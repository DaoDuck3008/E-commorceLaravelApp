<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $CartID
 * @property integer $UserID
 * @property string $CreatedAt
 * @property Cartitem[] $cartitems
 * @property User $user
 */
class Cart extends Model
{
    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'CartID';

    public $timestamps = true;
    const CREATED_AT = 'CreatedAt';
    const UPDATED_AT = 'UpdatedAt';


    protected $fillable = ['CartID','UserID' ,'ProductID', 'VersionID', 'ColorID', 'Quantity'];
    

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cartitems()
    {
        return $this->hasMany('App\Models\Cartitem', 'CartID', 'CartID');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'UserID', 'UserID');
    }

    public function getTotalQuantityAttribute()
    {
        return $this->cartitems()->sum('Quantity');
    }

    public function getTotalAmountAttribute()
    {
        $total = 0;
        
        foreach ($this->cartitems as $item) {
            $total += $item->total;
        }
        
        return $total;
    }
}
