<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $ProductID
 * @property integer $CategoryID
 * @property string $ProductName
 * @property string $Description
 * @property integer $Price
 * @property integer $StockQuantity
 * @property string $BrandID
 * @property string $WarrantyPeriod
 * @property string $ImageURL
 * @property string $CreatedAt
 * @property string $UpdatedAt
 * @property string $VideoLink
 * @property Cartitem[] $cartitems
 * @property Orderitem[] $orderitems
 * @property Productimg[] $productimgs
 * @property Category $category
 * @property Promotion[] $promotions
 * @property Review[] $reviews
 */
class Product extends Model
{
    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'ProductID';

    public $timestamps = true;

    const CREATED_AT = 'CreatedAt';
    const UPDATED_AT = 'UpdatedAt';

    /**
     * @var array
     */
    protected $fillable = ['CategoryID', 'ProductName', 'Description', 'Price', 'StockQuantity', 'BrandID', 'WarrantyPeriod', 'ImageURL', 'CreatedAt', 'UpdatedAt','VideoLink','AvgRate','CommentCount'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cartitems()
    {
        return $this->hasMany('App\Models\Cartitem', 'ProductID', 'ProductID');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orderitems()
    {
        return $this->hasMany('App\Models\Orderitem', 'ProductID', 'ProductID');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function productimgs()
    {
        return $this->hasMany('App\Models\Productimg', 'ProductID', 'ProductID');
    }

     /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function productversions()
    {
        return $this->hasMany('App\Models\Productversion', 'ProductID', 'ProductID');
    }

     /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function productcolors()
    {
        return $this->hasMany('App\Models\Productcolor', 'ProductID', 'ProductID');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function productspecifications()
    {
        return $this->hasMany('App\Models\Productspecification', 'ProductID', 'ProductID');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo('App\Models\Category', 'CategoryID', 'CategoryID');
    }

    public function brand()
    {
        return $this->belongsTo('App\Models\Brand', 'BrandID', 'BrandID');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function promotions()
    {
        return $this->belongsToMany('App\Models\Promotion', 'promotionproducts', 'ProductID', 'PromotionID');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reviews()
    {
        return $this->hasMany('App\Models\Review', 'ProductID', 'ProductID');
    }


     // Tính trung bình rating
     public function averageRating()
     {
         return $this->reviews()->avg('Rating');
     }
     
     // Đếm số comment
     public function commentCount()
     {
         return $this->reviews()->count();
     }

     public function getTotalStockQuantity(){
        return self::sum('StockQuantity');
     }

     public function getTotalPhone(){
        return self::whereHas('category', function($query) {$query->where('CategoryName','like',"%Điện thoại%");})->count();
     }

     public function getTotalLaptop(){
        return self::whereHas('category', function($query) {$query->where('CategoryName','like',"%Laptop%")
                                                                        ->orWhere('CategoryName','like',"%PC%");})->count();
     }
}
