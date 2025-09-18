# 🛒 E-commerce Laravel Application

## 📋 Yêu Cầu Hệ Thống

Trước khi bắt đầu, hãy đảm bảo bạn đã cài đặt:

-   **PHP** >= 8.0
-   **Composer** (Dependency Manager cho PHP)
-   **Node.js** & **NPM** (cho frontend assets)
-   **MySQL/MariaDB** (Database)
-   **Git** (Version Control)

## 🚀 Hướng Dẫn Cài Đặt

### Bước 1: Clone Repository

```bash
git clone <repository-url>
cd <project-name>
```

Nếu bạn đã có bản mềm của App rồi thì không phải thực hiện các bước này.

### Bước 2: Cấu Hình Environment

#### Tạo file `.env`

```bash
cp .env.example .env
```

Hoặc bạn có thể copy file .env.example sau đó xóa đuôi .example đi là được

#### Tạo Database

Tạo một database mới trong MySQL (database phải trống):

```sql
CREATE DATABASE your_database_name;
```

#### Cấu hình Database

Mở file `.env` và cập nhật thông tin database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### Bước 3: Cài Đặt Dependencies

#### Backend Dependencies

```bash
composer install
```

> 💡 **Lưu ý:** Nếu không có file `composer.lock`, hãy chạy:

```bash
composer update
```

#### Tạo Application Key

```bash
php artisan key:generate
```

#### Frontend Dependencies

```bash
npm install
```

### Bước 4: Thiết Lập Database



#### Chạy Migration

```bash
php artisan migrate
```

#### Chạy Seeder (Tạo dữ liệu mẫu)

```bash
php artisan db:seed
```

> 📊 **Dữ liệu mẫu bao gồm:**
>
> -   3 tài khoản: Admin, Staff, Customer
> -   Danh mục sản phẩm
> -   Thương hiệu sản phẩm

## 🎯 Khởi Động Ứng Dụng

### Terminal 1: Laravel Server

```bash
php artisan serve
```

### Terminal 2: Frontend Assets (Vite)

```bash
npm run dev
```

> 🌐 **Truy cập ứng dụng:** http://localhost:8000

## 👥 Tài Khoản Mặc Định

| Role     | Email                | Password |
| -------- | -------------------- | -------- |
| Admin    | admin@example.com    | password |
| Staff    | staff@example.com    | password |
| Customer | customer@example.com | password |

## 📁 Cấu Trúc Project

```
├── app/
│   ├── Models/          # Eloquent Models
│   ├── Http/Controllers/# Controllers
│   └── ...
├── database/
│   ├── migrations/      # Database Migrations
│   ├── seeders/         # Database Seeders
│   └── factories/       # Model Factories
├── resources/
│   ├── views/           # Blade Templates
│   ├── js/              # JavaScript Files
│   └── css/             # CSS Files
└── ...
```

## 🔧 Các Lệnh Hữu Ích

### Development

```bash
# Chạy migrations
php artisan migrate

# Rollback migrations
php artisan migrate:rollback

# Kết nối storage
```bash
php artisan storage:link
```

### Frontend

```bash
# Development mode (watch files)
npm run dev

# Production build
npm run build


```

## 🐛 Troubleshooting

### Lỗi thường gặp:

**1. Permission denied**

```bash
sudo chmod -R 755 storage/
sudo chmod -R 755 bootstrap/cache/
```

**2. Storage link không hoạt động**

```bash
php artisan storage:link
```

**3. Clear cache**

```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

## 🎉 Chúc Bạn Lập Trình Vui Vẻ!

> **Made with ❤️ using Laravel Framework**
