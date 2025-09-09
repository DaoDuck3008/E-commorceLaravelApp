<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $ReviewID
 * @property integer $ProductID
 * @property integer $UserID
 * @property boolean $Rating
 * @property string $COMMENT
 * @property string $CreatedAt
 * @property User $user
 * @property Product $product
 */
class Review extends Model
{
    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'ReviewID';

    /**
     * @var array
     */
    protected $fillable = ['ProductID', 'UserID', 'Rating', 'COMMENT', 'CreatedAt'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'UserID', 'UserID');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo('App\Models\Product', 'ProductID', 'ProductID');
    }
}
