<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $SpecID
 * @property integer $ProductID
 * @property string $SpecType
 * @property string $SpecValue
 */
class Productspecification extends Model
{
    
    protected $table = 'productspecifications';
    protected $primaryKey = 'SpecID';

    public $timestamps = false;

    protected $fillable = ['ProductID','SpecType', 'SpecValue'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo('App\Models\Product', 'ProductID', 'ProductID');
    }
}
