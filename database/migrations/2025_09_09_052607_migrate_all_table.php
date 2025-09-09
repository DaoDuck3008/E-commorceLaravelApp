<?php
// 2025_01_01_000001_create_ecommerce_tables.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Create users table
        Schema::create('users', function (Blueprint $table) {
            $table->id('UserID');
            $table->string('FullName', 100);
            $table->string('Email', 100)->unique();
            $table->string('PasswordHash', 255);
            $table->string('PhoneNumber', 20)->nullable();
            $table->text('Address')->nullable();
            $table->enum('Role', ['Customer', 'Admin', 'Staff'])->default('Customer');
            $table->timestamp('CreatedAt')->useCurrent();
            $table->timestamp('UpdatedAt')->useCurrent()->useCurrentOnUpdate();
            $table->rememberToken();
        });

        // Create categories table
        Schema::create('categories', function (Blueprint $table) {
            $table->id('CategoryID');
            $table->string('CategoryName', 50);
            $table->text('Description')->nullable();
            $table->integer('Priority')->default(100);
        });

        // Create brands table
        Schema::create('brands', function (Blueprint $table) {
            $table->id('BrandID');
            $table->string('BrandName', 255);
            $table->unsignedBigInteger('CategoryID');
            $table->string('Description', 255);
            
            $table->foreign('CategoryID')->references('CategoryID')->on('categories')->onDelete('cascade');
        });

        // Create products table
        Schema::create('products', function (Blueprint $table) {
            $table->id('ProductID');
            $table->unsignedBigInteger('CategoryID');
            $table->string('ProductName', 100);
            $table->text('Description')->nullable();
            $table->integer('Price');
            $table->integer('StockQuantity')->default(0);
            $table->unsignedBigInteger('BrandID');
            $table->string('WarrantyPeriod', 50)->nullable();
            $table->string('ImageURL', 255)->nullable();
            $table->timestamp('CreatedAt')->useCurrent();
            $table->timestamp('UpdatedAt')->useCurrent()->useCurrentOnUpdate();
            $table->string('VideoLink', 255);
            
            $table->foreign('CategoryID')->references('CategoryID')->on('categories');
            $table->foreign('BrandID')->references('BrandID')->on('brands')->onDelete('cascade');
        });

        // Create productspecifications table
        Schema::create('productspecifications', function (Blueprint $table) {
            $table->id('SpecID');
            $table->unsignedBigInteger('ProductID');
            $table->string('SpecType', 255);
            $table->text('SpecValue');
            
            $table->foreign('ProductID')->references('ProductID')->on('products')->onDelete('cascade');
        });

        // Create productversions table
        Schema::create('productversions', function (Blueprint $table) {
            $table->id('VersionID');
            $table->unsignedBigInteger('ProductID');
            $table->string('VersionName', 100);
            $table->unsignedInteger('Price');
            
            $table->foreign('ProductID')->references('ProductID')->on('products')->onDelete('cascade');
        });

        // Create productcolors table
        Schema::create('productcolors', function (Blueprint $table) {
            $table->id('ColorID');
            $table->unsignedBigInteger('ProductID');
            $table->string('Color', 100);
            $table->string('ImgURL', 255);
            
            $table->foreign('ProductID')->references('ProductID')->on('products')->onDelete('cascade');
        });

        // Create productimgs table
        Schema::create('productimgs', function (Blueprint $table) {
            $table->id('ImgID');
            $table->unsignedBigInteger('ProductID');
            $table->string('ImgURL', 255);
            
            $table->foreign('ProductID')->references('ProductID')->on('products')->onDelete('cascade');
        });

        // Create carts table
        Schema::create('carts', function (Blueprint $table) {
            $table->id('CartID');
            $table->unsignedBigInteger('UserID');
            $table->timestamp('CreatedAt')->useCurrent();
            
            $table->foreign('UserID')->references('UserID')->on('users');
        });

        // Create cartitems table
        Schema::create('cartitems', function (Blueprint $table) {
            $table->id('CartItemID');
            $table->unsignedBigInteger('CartID');
            $table->unsignedBigInteger('ProductID');
            $table->integer('Quantity')->default(1);
            
            $table->foreign('CartID')->references('CartID')->on('carts');
            $table->foreign('ProductID')->references('ProductID')->on('products');
        });

        // Create orders table
        Schema::create('orders', function (Blueprint $table) {
            $table->id('OrderID');
            $table->unsignedBigInteger('UserID');
            $table->timestamp('OrderDate')->useCurrent();
            $table->decimal('TotalAmount', 10, 2);
            $table->enum('STATUS', ['Pending', 'Confirmed', 'Shipped', 'Completed', 'Cancelled'])->default('Pending');
            $table->text('ShippingAddress');
            $table->string('PaymentMethod', 50)->nullable();
            
            $table->foreign('UserID')->references('UserID')->on('users');
        });

        // Create orderitems table
        Schema::create('orderitems', function (Blueprint $table) {
            $table->id('OrderItemID');
            $table->unsignedBigInteger('OrderID');
            $table->unsignedBigInteger('ProductID');
            $table->integer('Quantity');
            $table->decimal('Price', 10, 2);
            
            $table->foreign('OrderID')->references('OrderID')->on('orders');
            $table->foreign('ProductID')->references('ProductID')->on('products');
        });

        // Create payments table
        Schema::create('payments', function (Blueprint $table) {
            $table->id('PaymentID');
            $table->unsignedBigInteger('OrderID');
            $table->timestamp('PaymentDate')->useCurrent();
            $table->decimal('Amount', 10, 2);
            $table->enum('PaymentMethod', ['CreditCard', 'COD', 'BankTransfer', 'E-Wallet']);
            $table->string('STATUS', 50)->nullable();
            
            $table->foreign('OrderID')->references('OrderID')->on('orders');
        });

        // Create reviews table
        Schema::create('reviews', function (Blueprint $table) {
            $table->id('ReviewID');
            $table->unsignedBigInteger('ProductID');
            $table->unsignedBigInteger('UserID');
            $table->tinyInteger('Rating')->unsigned()->checkBetween(1, 5);
            $table->text('COMMENT')->nullable();
            $table->timestamp('CreatedAt')->useCurrent();
            
            $table->foreign('ProductID')->references('ProductID')->on('products');
            $table->foreign('UserID')->references('UserID')->on('users');
        });

        // Create promotions table
        Schema::create('promotions', function (Blueprint $table) {
            $table->id('PromotionID');
            $table->string('Title', 100);
            $table->text('Description')->nullable();
            $table->decimal('DiscountPercent', 5, 2);
            $table->date('StartDate');
            $table->date('EndDate');
        });

        // Create promotionproducts table
        Schema::create('promotionproducts', function (Blueprint $table) {
            $table->unsignedBigInteger('PromotionID');
            $table->unsignedBigInteger('ProductID');
            
            $table->primary(['PromotionID', 'ProductID']);
            $table->foreign('PromotionID')->references('PromotionID')->on('promotions');
            $table->foreign('ProductID')->references('ProductID')->on('products');
        });
    }

    public function down()
    {
        Schema::dropIfExists('promotionproducts');
        Schema::dropIfExists('promotions');
        Schema::dropIfExists('reviews');
        Schema::dropIfExists('payments');
        Schema::dropIfExists('orderitems');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('cartitems');
        Schema::dropIfExists('carts');
        Schema::dropIfExists('productimgs');
        Schema::dropIfExists('productcolors');
        Schema::dropIfExists('productversions');
        Schema::dropIfExists('productspecifications');
        Schema::dropIfExists('products');
        Schema::dropIfExists('brands');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('users');
    }
};