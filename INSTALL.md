# Mixpost Lite - Facebook Only / Publish Now

Phiên bản tối giản của Mixpost Lite, chỉ giữ Facebook, bỏ Twitter/Mastodon/Horizon/queue, đăng bài ngay lập tức.

## Yêu cầu

- PHP 8.2+
- Composer
- Node.js 18+
- SQLite (đã có sẵn trên hầu hết các distro Linux)

## Cài đặt nhanh

```bash
# 1. Clone hoặc copy repo về
cd /home/danh/mixpost_repo_fbonly

# 2. Cài đặt PHP dependencies
composer install

# 3. Cài đặt Node dependencies
npm install

# 4. Build frontend
npm run build

# 5. Tạo file .env
cp .env.example .env
php artisan key:generate

# 6. Tạo database SQLite
touch database/database.sqlite

# 7. Chạy migration
php artisan migrate

# 8. Tạo storage link
php artisan storage:link

# 9. Chạy server
php artisan serve
```

## Truy cập

- Web: http://localhost:8000/mixpost
- Tài khoản admin: tạo qua `php artisan make:user` hoặc đăng ký trực tiếp

## Cấu hình Facebook

1. Truy cập http://localhost:8000/mixpost/services
2. Thêm Facebook App ID + Secret vào form Facebook service
3. Thêm Page vào Accounts

## Lưu ý

- Database: SQLite file tại `database/database.sqlite`
- Queue: đồng bộ (`sync`), không cần Redis/Horizon
- Uploads: lưu trong `storage/app/public`
- Logs: `storage/logs/laravel.log`

## Test

```bash
# Chạy test
composer test

# Hoặc
php artisan test
```

## Deploy

Xem hướng dẫn deploy tại [DEPLOY.md](./DEPLOY.md).
