<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


/**
 * @property integer $CommentID
 * @property integer $UserID
 * @property integer $UserID
 * @property string $Comment
 * @property integer $Rate
 * @property User $user
 * @property Product $product
 */
class Comment extends Model
{
    protected $primaryKey = 'CommentID';

    public $timestamps = true;

    protected $fillable = ['CommentID','UserID','ProductID','Comment','Rate','CreatedAt', 'UpdatedAt'];

    public function user()
    {
        return $this->belongsTo('App\Models\User','UserID','UserID');
    }

    public function product()
    {
        return $this->belongsTo('App\Models\Product','ProductID','ProductID');
    }
}
