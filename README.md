# Filament Admin

Ho va ten: Pham Nguyen Hung

MSV: 23810310276

Lop: D18CNPM2

Phan he admin cho bai tap quan ly danh muc va san pham voi MSSV `23810310276`.

## Cong nghe

- Laravel 10
- Filament 3.3
- SQLite local database

## Rang buoc da ap dung

- Tat ca bang database deu duoc prefix `sv23810310276_`
- Slug resource Filament:
  - `admin/sv23810310276/categories`
  - `admin/sv23810310276/products`
- Primary color Filament da doi sang `Emerald`
- Truong sang tao cho `Product`: `discount_percent`
  - Tu dong tinh gia sau giam
  - Neu `stock_quantity <= 0` thi status se tu dong chuyen sang `out_of_stock`

## Tai khoan admin mac dinh

- Email: `admin@sv23810310276.local`
- Password: `password`

## Chuc nang chinh

- Category
  - Tu dong tao slug theo name
  - Loc theo `is_visible`
- Product
  - Form dung Grid layout
  - `RichEditor` cho mo ta
  - Upload 1 anh dai dien
  - Tim kiem theo ten
  - Loc theo danh muc
  - Gia hien thi dinh dang VND
  - Validation:
    - `price >= 0`
    - `stock_quantity` la so nguyen

## Chay du an

```bash
composer install
php artisan migrate:fresh --seed
php artisan storage:link
php artisan serve
```

Dang nhap admin tai `http://127.0.0.1:8000/admin`.

## Ghi chu nop bai

Repo local da duoc chuan bi de tach thanh it nhat 5 commits ro rang. Ban chi can push len GitHub/GitLab va nop link repo.
