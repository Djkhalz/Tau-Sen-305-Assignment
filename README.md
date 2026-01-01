# Tau-Sen-305-Assignment
# Laravel Blog Assignment

## ..........Setup Project.............

**Terminal**

```bash
cd /path/to/laragon/www
mkdir my_first_app
cd my_first_app
```

Paste all project files into this folder, then run:

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan jwt:secret
```

---

## ..........Setup Database.............

1. Create a MySQL database named:

```
my_first_app
```

2. Update `.env` file:

```
DB_DATABASE=my_first_app
DB_USERNAME=root
DB_PASSWORD=
```

3. Run migrations:

```bash
php artisan migrate
```

---

## ..........Create Admin User.............

```bash
php artisan tinker
```

Inside tinker:

```php
App\\Models\\User::create([
  'name' => 'Admin',
  'email' => 'ainafolahanblogsystem.com',
  'password' => bcrypt('password123'),
  'role' => 'admin'
]);
exit
```

---

## ..........Start Server.............

```bash
php artisan serve
```

Open in browser:

```
http://localhost:8000
```

---

## ..........JWT Authentication APIs.............

### 1. Get Token (Login)

```bash
curl -X POST http://localhost:8000/api/auth/login ^
 -H "Content-Type: application/json" ^
 -d "{\"email\":\"ainafolahanblogsystem.com\",\"password\":\"password123\"}"
```

### 2. Test Profile (Replace YOUR_TOKEN)

```bash
curl -X GET http://localhost:8000/api/auth/profile ^
 -H "Authorization: Bearer YOUR_TOKEN"
```

### 3. Logout

```bash
curl -X POST http://localhost:8000/api/auth/logout ^
 -H "Authorization: Bearer YOUR_TOKEN"
```

---

## ..........Public APIs (No Token Required).............

### 4. Get All Posts

```bash
curl http://localhost:8000/api/posts
```

### 5. Submit Comment

```bash
curl -X POST http://localhost:8000/api/posts/test-post-slug/comments ^
 -H "Content-Type: application/json" ^
 -d "{\"author\":\"aina folahan\",\"content\":\"Great article!\"}"
```

---

## ..........Web Pages.............

| Page        | URL                                                                                  |
| ----------- | ------------------------------------------------------------------------------------ |
| Homepage    | [http://localhost:8000](http://localhost:8000)                                       |
| Admin Login | [http://localhost:8000/login](http://localhost:8000/login)                           |
| Admin Posts | [http://localhost:8000/admin/posts](http://localhost:8000/admin/posts)               |
| Create Post | [http://localhost:8000/admin/posts/create](http://localhost:8000/admin/posts/create) |
| View Post   | [http://localhost:8000/post/{slug}](http://localhost:8000/post/{slug})               |

### Admin Login Credentials

```
Email: aina.folahan@blogsystem.com
Password: password123
```

---

## ..........Screenshots.............

Screenshots are saved in the **screenshots** folder.

Required screenshots:

* `All blogs.png` – Public blog listing
* `Admin login.png` – Admin login page
* `admin dashboard.png` – Admin dashboard
* `createpost.png` – Create post form
* `Login DB.png` – Users table
* `Post DB.png` – Posts table



