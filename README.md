# Flower Shop Web App - Laravel Project 🌸

## 1. Giới thiệu

Dự án xây dựng một ứng dụng web quản lý cửa hàng hoa sử dụng **framework Laravel (12.x)**, đáp ứng các yêu cầu thiết kế ứng dụng web theo tiêu chuẩn học tập.

Ứng dụng tập trung vào việc quản lý 3 đối tượng chính:
- **User**
- **Product**
- **Order**

Bao gồm các chức năng:
- Xác thực và phân quyền người dùng (Admin/User)
- Chức năng CRUD cho sản phẩm và đơn hàng

---

## 2. Yêu cầu và phân tích

### 2.1. Yêu cầu kỹ thuật

- **Framework**: Laravel 12.x + Breeze
- **Chức năng chính**:
  - Xác thực & phân quyền (Auth/AuthZ) với Breeze
  - CRUD cho Order
- **Bảo mật**:
  - CSRF Protection với `@csrf`
  - XSS Prevention với `{{ e() }}`
  - Validation với Laravel `rules`
  - Middleware Auth & Role
  - SQL Injection: phòng chống qua Eloquent & Query Builder
- **Database**: Aiven for MySQL (cloud)
- **Migrate**: sử dụng Eloquent ORM

### 2.2. Phân tích đối tượng

- **User**
  - Đăng nhập, phân quyền (admin/user)
- **Product**
  - Quản lý tên, giá, danh mục
- **Order**
  - Quản lý đơn hàng: liên kết với User & Product
  - Trạng thái: `pending`, `confirmed`, `completed`

---

## 3. Thiết kế và triển khai

### 3.1. Cơ sở dữ liệu (MySQL - Aiven)

Các bảng chính (được migrate qua Eloquent):

#### `users` table
| Tên cột           | Kiểu dữ liệu      |
|-------------------|-------------------|
| id                | integer, PK        |
| name              | varchar            |
| email             | varchar            |
| password          | varchar            |
| role              | varchar            |
| email_verified_at | timestamp          |
| created_at        | timestamp          |
| updated_at        | timestamp          |

#### `products` table
| Tên cột   | Kiểu dữ liệu      |
|-----------|-------------------|
| id        | integer, PK        |
| name      | varchar            |
| price     | decimal            |
| category_id | integer, FK     |
| created_at | timestamp        |
| updated_at | timestamp        |

#### `orders` table
| Tên cột   | Kiểu dữ liệu      |
|-----------|-------------------|
| id        | integer, PK        |
| user_id   | integer, FK        |
| product_id | integer, FK       |
| quantity  | integer            |
| status    | varchar            |
| created_at | timestamp         |
| updated_at | timestamp         |

---

### 3.2. Controllers

- `LoginController`:
  - Xử lý đăng nhập, đăng xuất (Breeze)
- `OrderController`:
  - `index`: Danh sách đơn hàng
  - `store`: Tạo đơn hàng
  - `update`: Cập nhật đơn hàng
  - `destroy`: Xóa đơn hàng

---

### 3.3. Routes (`routes/web.php`)

```php
Route::middleware('guest')->get('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout']);

Route::middleware(['auth', 'role'])->group(function () {
    Route::get('/orders', [OrderController::class, 'index']);
    Route::post('/orders', [OrderController::class, 'store']);
    Route::put('/orders/{id}', [OrderController::class, 'update']);
    Route::delete('/orders/{id}', [OrderController::class, 'destroy']);
});
