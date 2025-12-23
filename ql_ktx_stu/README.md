# 🚀 ĐỒ ÁN THỰC TẬP – HỆ THỐNG QUẢN LÝ KÝ TÚC XÁ
**Công nghệ sử dụng:** Laravel 12, PHP 8.2+, MySQL 5.7/8.0
---

# 🛠 Cài đặt & chạy dự án

## 📥 Clone dự án
```bash
git clone <link-repo>
cd ql_ktx_stu
```

## 📦 Cài đặt thư viện PHP
```bash
composer install
```

## ⚙️ Tạo file môi trường
```bash
cp .env.example .env
```
Cập nhật thông tin database trong `.env`.

## 🔑 Generate key
```bash
php artisan key:generate
```

## 🏗 Migration + Seeder
```bash
php artisan migrate --seed
```

## ▶ Chạy server
```bash
php artisan serve
```

---

# 🔐 Tài khoản mẫu
| Role  | Email           | Password |
|-------|------------------|----------|
| Admin | admin@test.com   | 123456   |

---

# 📁 Cấu trúc thư mục
```
app/
bootstrap/
config/
database/
public/
resources/
routes/
storage/
```

