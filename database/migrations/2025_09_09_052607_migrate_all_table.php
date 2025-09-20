<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Bảng categories
        Schema::create('categories', function (Blueprint $table) {
            $table->integer('CategoryID')->primary();
            $table->string('CategoryName', 50);
            $table->text('Description')->nullable();
            $table->integer('Priority')->default(100);
            $table->string('Icon')->nullable();
        });

        // Bảng brands
        Schema::create('brands', function (Blueprint $table) {
            $table->unsignedInteger('BrandID')->autoIncrement();
            $table->string('BrandName', 255);
            $table->integer('CategoryID');
            $table->string('Description', 255);
            
            $table->foreign('CategoryID')->references('CategoryID')->on('categories')->onDelete('cascade');
        });

        // Bảng users
        Schema::create('users', function (Blueprint $table) {
            $table->integer('UserID')->autoIncrement();
            $table->string('FullName', 100);
            $table->string('Email', 100)->unique();
            $table->string('PasswordHash', 255);
            $table->string('PhoneNumber', 20)->nullable();
            $table->text('Address')->nullable();
            $table->enum('Role', ['Customer', 'Admin', 'Staff'])->default('Customer');
            $table->timestamp('CreatedAt')->useCurrent();
            $table->timestamp('UpdatedAt')->useCurrent()->useCurrentOnUpdate();
            $table->string('remember_token', 255)->default('');
        });

        // Bảng products
        Schema::create('products', function (Blueprint $table) {
            $table->integer('ProductID')->autoIncrement();
            $table->integer('CategoryID');
            $table->string('ProductName', 100);
            $table->text('Description')->nullable();
            $table->integer('Price');
            $table->integer('StockQuantity')->default(0);
            $table->unsignedInteger('BrandID');
            $table->string('WarrantyPeriod', 50)->nullable();
            $table->string('ImageURL', 255)->nullable();
            $table->timestamp('CreatedAt')->useCurrent();
            $table->timestamp('UpdatedAt')->useCurrent()->useCurrentOnUpdate();
            $table->string('VideoLink', 255)->default('');
            $table->decimal('AvgRate', 10, 2)->nullable();
            $table->integer('CommentCount')->nullable();
            
            $table->foreign('CategoryID')->references('CategoryID')->on('categories');
            $table->foreign('BrandID')->references('BrandID')->on('brands')->onDelete('cascade');
        });

        // Bảng productversions
        Schema::create('productversions', function (Blueprint $table) {
            $table->unsignedInteger('VersionID')->autoIncrement();
            $table->integer('ProductID');
            $table->string('VersionName', 100);
            $table->unsignedInteger('Price');
            
            $table->foreign('ProductID')->references('ProductID')->on('products')->onDelete('cascade');
        });

        // Bảng productcolors
        Schema::create('productcolors', function (Blueprint $table) {
            $table->unsignedInteger('ColorID')->autoIncrement();
            $table->integer('ProductID');
            $table->string('Color', 100);
            $table->string('ImgURL', 255);
            
            $table->foreign('ProductID')->references('ProductID')->on('products')->onDelete('cascade');
        });

        // Bảng productspecifications
        Schema::create('productspecifications', function (Blueprint $table) {
            $table->unsignedInteger('SpecID')->autoIncrement();
            $table->integer('ProductID');
            $table->string('SpecType', 255);
            $table->text('SpecValue');
            
            $table->foreign('ProductID')->references('ProductID')->on('products')->onDelete('cascade');
        });

        // Bảng productimgs
        Schema::create('productimgs', function (Blueprint $table) {
            $table->integer('ImgID')->autoIncrement();
            $table->integer('ProductID');
            $table->string('ImgURL', 255);
            
            $table->foreign('ProductID')->references('ProductID')->on('products')->onDelete('cascade');
        });

        // Bảng carts
        Schema::create('carts', function (Blueprint $table) {
            $table->integer('CartID')->autoIncrement();
            $table->integer('UserID');
            $table->timestamp('CreatedAt')->useCurrent();
            $table->boolean('Completed')->default(false);
            $table->timestamp('UpdatedAt')->useCurrent()->useCurrentOnUpdate();
            
            $table->foreign('UserID')->references('UserID')->on('users');
        });

        // Bảng cartitems
        Schema::create('cartitems', function (Blueprint $table) {
            $table->integer('CartItemID')->autoIncrement();
            $table->integer('CartID');
            $table->integer('ProductID');
            $table->integer('Quantity')->default(1);
            $table->unsignedInteger('VersionID')->nullable();
            $table->unsignedInteger('ColorID')->nullable();
            
            $table->foreign('CartID')->references('CartID')->on('carts');
            $table->foreign('ProductID')->references('ProductID')->on('products');
            $table->foreign('VersionID')->references('VersionID')->on('productversions');
            $table->foreign('ColorID')->references('ColorID')->on('productcolors');
        });

        // Bảng orders
        Schema::create('orders', function (Blueprint $table) {
            $table->integer('OrderID')->autoIncrement();
            $table->integer('UserID');
            $table->timestamp('OrderDate')->useCurrent();
            $table->decimal('TotalAmount', 10, 2);
            $table->enum('STATUS', ['Pending', 'Confirmed', 'Shipped', 'Completed', 'Cancelled'])->default('Pending');
            $table->text('ShippingAddress');
            $table->string('PaymentMethod', 50)->nullable();
            $table->text('Description')->nullable();
            $table->text('CancelReason')->nullable();
            
            $table->foreign('UserID')->references('UserID')->on('users');
        });

        // Bảng orderitems
        Schema::create('orderitems', function (Blueprint $table) {
            $table->integer('OrderItemID')->autoIncrement();
            $table->integer('OrderID');
            $table->integer('ProductID');
            $table->integer('Quantity');
            $table->decimal('Price', 12, 2);
            $table->unsignedInteger('VersionID')->nullable();
            $table->unsignedInteger('ColorID')->nullable();
            
            $table->foreign('OrderID')->references('OrderID')->on('orders');
            $table->foreign('ProductID')->references('ProductID')->on('products');
            $table->foreign('VersionID')->references('VersionID')->on('productversions');
            $table->foreign('ColorID')->references('ColorID')->on('productcolors');
        });

        // Bảng payments
        Schema::create('payments', function (Blueprint $table) {
            $table->integer('PaymentID')->autoIncrement();
            $table->integer('OrderID');
            $table->timestamp('PaymentDate')->useCurrent();
            $table->decimal('Amount', 12, 2);
            $table->enum('PaymentMethod', ['CreditCard', 'COD', 'BankTransfer', 'E-Wallet']);
            $table->string('STATUS', 50)->nullable();
            
            $table->foreign('OrderID')->references('OrderID')->on('orders');
        });

        // Bảng promotions
        Schema::create('promotions', function (Blueprint $table) {
            $table->integer('PromotionID')->autoIncrement();
            $table->string('Title', 100);
            $table->text('Description')->nullable();
            $table->decimal('DiscountPercent', 5, 2)->nullable();
            $table->date('StartDate')->nullable();
            $table->date('EndDate')->nullable();
            $table->string('ImgURL');
        });

        // Bảng promotionproducts
        Schema::create('promotionproducts', function (Blueprint $table) {
            $table->integer('PromotionID');
            $table->integer('ProductID');
            
            $table->primary(['PromotionID', 'ProductID']);
            $table->foreign('PromotionID')->references('PromotionID')->on('promotions');
            $table->foreign('ProductID')->references('ProductID')->on('products');
        });

        // Bảng reviews
        Schema::create('reviews', function (Blueprint $table) {
            $table->integer('ReviewID')->autoIncrement();
            $table->integer('ProductID');
            $table->integer('UserID');
            $table->unsignedTinyInteger('Rating')->check('Rating BETWEEN 1 AND 5');
            $table->text('COMMENT')->nullable();
            $table->timestamp('CreatedAt')->useCurrent();
            
            $table->foreign('ProductID')->references('ProductID')->on('products');
            $table->foreign('UserID')->references('UserID')->on('users');
        });

        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('migrations');
        Schema::dropIfExists('reviews');
        Schema::dropIfExists('promotionproducts');
        Schema::dropIfExists('promotions');
        Schema::dropIfExists('payments');
        Schema::dropIfExists('orderitems');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('cartitems');
        Schema::dropIfExists('carts');
        Schema::dropIfExists('productimgs');
        Schema::dropIfExists('productspecifications');
        Schema::dropIfExists('productcolors');
        Schema::dropIfExists('productversions');
        Schema::dropIfExists('products');
        Schema::dropIfExists('users');
        Schema::dropIfExists('brands');
        Schema::dropIfExists('categories');
    }
};