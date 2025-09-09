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

    /**
     * @var array
     */
    protected $fillable = ['UserID', 'CreatedAt'];

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
}
