# Mixpost Lite - Test nhanh với SQLite

## Backend test

```bash
cd /home/danh/mixpost_repo_fbonly

# Cài dependencies
composer install

# Tạo .env
cp .env.example .env
php artisan key:generate

# Tạo database SQLite
touch database/database.sqlite

# Chạy migration
php artisan migrate --force

# Chạy server
php artisan serve
```

## Frontend test

```bash
npm install
npm run build
```

## Test suite

```bash
# Chạy test
php artisan test
```

## Lưu ý

- Test mặc định dùng SQLite
- File database: `database/database.sqlite`
- Queue: sync mode, không cần Redis/Horizon
- Logs: `storage/logs/laravel.log`
