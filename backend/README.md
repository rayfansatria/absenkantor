# AbsenKantor Backend API

Backend API untuk sistem absensi kantor AbsenKantor, dibangun dengan Laravel 10.x dan JWT Authentication.

## Features

- JWT Authentication dengan tymon/jwt-auth
- RESTful API untuk mobile application
- Multi-tenant architecture (institution-based)
- GPS validation untuk attendance
- File upload (photos, documents)
- Complete CRUD operations untuk semua fitur

## Tech Stack

- **Framework**: Laravel 10.x
- **PHP**: 8.1+
- **Database**: MySQL 5.7+
- **Authentication**: JWT (tymon/jwt-auth)
- **Image Processing**: Intervention Image
- **PDF Generation**: DomPDF

## Installation

### Prerequisites

- PHP 8.1 or higher
- Composer
- MySQL 5.7 or higher
- Git

### Setup Steps

1. Install dependencies:
```bash
composer install
```

2. Copy environment file:
```bash
cp .env.example .env
```

3. Configure database di `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_absensi_general
DB_USERNAME=root
DB_PASSWORD=
```

4. Generate application key:
```bash
php artisan key:generate
```

5. Generate JWT secret:
```bash
php artisan jwt:secret
```

6. Run migrations:
```bash
php artisan migrate
```

7. Create storage symbolic link:
```bash
php artisan storage:link
```

8. Start development server:
```bash
php artisan serve
```

API akan berjalan di `http://localhost:8000`

## API Documentation

### Base URL
```
http://localhost:8000/api
```

### Authentication Endpoints

#### Login
```http
POST /api/auth/login
Content-Type: application/json

{
  "username": "admin",
  "password": "password"
}
```

#### Logout
```http
POST /api/auth/logout
Authorization: Bearer {token}
```

#### Refresh Token
```http
POST /api/auth/refresh
Authorization: Bearer {token}
```

### Profile Endpoints

#### Get Profile
```http
GET /api/profile
Authorization: Bearer {token}
```

#### Update Profile
```http
PUT /api/profile
Authorization: Bearer {token}
Content-Type: application/json

{
  "email": "user@example.com",
  "phone": "08123456789",
  "address": "Jl. Example No. 123"
}
```

#### Change Password
```http
PUT /api/profile/password
Authorization: Bearer {token}
Content-Type: application/json

{
  "current_password": "oldpassword",
  "new_password": "newpassword",
  "new_password_confirmation": "newpassword"
}
```

#### Upload Avatar
```http
POST /api/profile/avatar
Authorization: Bearer {token}
Content-Type: multipart/form-data

avatar: [file]
```

### Attendance Endpoints

#### Clock In
```http
POST /api/attendance/clock-in
Authorization: Bearer {token}
Content-Type: multipart/form-data

latitude: -6.200000
longitude: 106.816666
photo: [file]
location: "Kantor Pusat"
```

#### Clock Out
```http
POST /api/attendance/clock-out
Authorization: Bearer {token}
Content-Type: multipart/form-data

latitude: -6.200000
longitude: 106.816666
photo: [file]
location: "Kantor Pusat"
```

#### Get Today's Attendance
```http
GET /api/attendance/today
Authorization: Bearer {token}
```

#### Get Attendance History
```http
GET /api/attendance/history?month=12&year=2024&per_page=15
Authorization: Bearer {token}
```

#### Get Monthly Summary
```http
GET /api/attendance/summary?month=12&year=2024
Authorization: Bearer {token}
```

#### Get Valid Locations
```http
GET /api/attendance/locations
Authorization: Bearer {token}
```

### Leave Endpoints

#### List Leave Requests
```http
GET /api/leaves?per_page=15
Authorization: Bearer {token}
```

#### Create Leave Request
```http
POST /api/leaves
Authorization: Bearer {token}
Content-Type: multipart/form-data

leave_type_id: 1
start_date: 2024-12-10
end_date: 2024-12-12
reason: "Alasan cuti minimal 10 karakter"
attachment: [file] (optional)
```

#### Get Leave Detail
```http
GET /api/leaves/{id}
Authorization: Bearer {token}
```

#### Cancel Leave Request
```http
DELETE /api/leaves/{id}
Authorization: Bearer {token}
```

#### Get Leave Types
```http
GET /api/leaves/types
Authorization: Bearer {token}
```

#### Get Leave Balance
```http
GET /api/leaves/balance
Authorization: Bearer {token}
```

### Overtime Endpoints

#### List Overtime Requests
```http
GET /api/overtimes?per_page=15
Authorization: Bearer {token}
```

#### Create Overtime Request
```http
POST /api/overtimes
Authorization: Bearer {token}
Content-Type: application/json

{
  "date": "2024-12-04",
  "start_time": "18:00",
  "end_time": "21:00",
  "reason": "Menyelesaikan laporan bulanan"
}
```

#### Get Overtime Detail
```http
GET /api/overtimes/{id}
Authorization: Bearer {token}
```

### Schedule Endpoints

#### Get Work Schedules
```http
GET /api/schedules?month=12&year=2024
Authorization: Bearer {token}
```

#### Get Available Shifts
```http
GET /api/schedules/shifts
Authorization: Bearer {token}
```

#### Get Holidays
```http
GET /api/holidays?year=2024
Authorization: Bearer {token}
```

### Payroll Endpoints

#### List Payslips
```http
GET /api/payslips?per_page=15
Authorization: Bearer {token}
```

#### Get Payslip Detail
```http
GET /api/payslips/{id}
Authorization: Bearer {token}
```

#### Download Payslip PDF
```http
GET /api/payslips/{id}/download
Authorization: Bearer {token}
```

### Notification Endpoints

#### List Notifications
```http
GET /api/notifications?per_page=20
Authorization: Bearer {token}
```

#### Mark as Read
```http
PUT /api/notifications/{id}/read
Authorization: Bearer {token}
```

#### Mark All as Read
```http
PUT /api/notifications/read-all
Authorization: Bearer {token}
```

### Announcement Endpoints

#### List Announcements
```http
GET /api/announcements?per_page=10
Authorization: Bearer {token}
```

## Response Format

### Success Response
```json
{
  "success": true,
  "message": "Operation successful",
  "data": {}
}
```

### Error Response
```json
{
  "success": false,
  "message": "Error message"
}
```

### Validation Error Response
```json
{
  "success": false,
  "message": "Validation failed",
  "errors": {
    "field_name": ["Error message"]
  }
}
```

## Testing

Run tests:
```bash
php artisan test
```

## Directory Structure

```
backend/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   └── Api/          # API Controllers
│   │   ├── Middleware/       # Custom Middleware
│   │   └── Requests/         # Form Request Validation
│   ├── Models/               # Eloquent Models
│   └── Providers/            # Service Providers
├── config/                   # Configuration files
├── database/
│   └── migrations/           # Database migrations
├── routes/
│   ├── api.php              # API routes
│   └── web.php              # Web routes
├── storage/                  # Storage directory
│   ├── app/
│   │   └── public/          # Public storage (avatars, photos)
│   ├── framework/
│   └── logs/
└── public/                   # Public directory
```

## Configuration

### CORS
CORS configuration is in `config/cors.php`. Default allows all origins for development.

### JWT
JWT configuration is in `config/jwt.php`:
- `JWT_TTL`: Token expiration time (default: 60 minutes)
- `JWT_REFRESH_TTL`: Refresh token expiration (default: 20160 minutes / 14 days)

### Attendance
Attendance configuration in `.env`:
- `ATTENDANCE_RADIUS`: GPS validation radius in meters (default: 100m)
- `ATTENDANCE_PHOTO_MAX_SIZE`: Maximum photo size in KB (default: 2048KB)

## Production Deployment

1. Set environment to production:
```env
APP_ENV=production
APP_DEBUG=false
```

2. Optimize Laravel:
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

3. Set proper permissions:
```bash
chmod -R 755 storage bootstrap/cache
```

4. Configure web server (Nginx/Apache)
5. Set up SSL certificate
6. Configure queue workers
7. Set up cron jobs

## Support

For issues and questions, please open an issue on GitHub.

## License

MIT License
