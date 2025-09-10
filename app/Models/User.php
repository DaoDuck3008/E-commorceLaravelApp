<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable; 
use Illuminate\Notifications\Notifiable;

/**
 * @property integer $UserID
 * @property string $FullName
 * @property string $Email
 * @property string $PasswordHash
 * @property string $PhoneNumber
 * @property string $Address
 * @property string $Role
 * @property string $CreatedAt
 * @property string $UpdatedAt
 * @property Cart[] $carts
 * @property Order[] $orders
 * @property Review[] $reviews
 */
class User extends Authenticatable
{
    use Notifiable;
    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'UserID';

    public $timestamps = true;

    const CREATED_AT = 'CreatedAt';
    const UPDATED_AT = 'UpdatedAt';

    public function getAuthPassword()
    {
        return $this->PasswordHash;
    }


    /**
     * @var array
     */
    protected $fillable = ['FullName', 'Email', 'PasswordHash', 'PhoneNumber', 'Address', 'Role', 'CreatedAt', 'UpdatedAt'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function carts()
    {
        return $this->hasMany('App\Models\Cart', 'UserID', 'UserID');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders()
    {
        return $this->hasMany('App\Models\Order', 'UserID', 'UserID');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reviews()
    {
        return $this->hasMany('App\Models\Review', 'UserID', 'UserID');
    }

}
