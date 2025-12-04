# AbsenKantor - Office Attendance System

Complete office attendance application with Flutter mobile app and Laravel backend API.

## 📱 Project Overview

AbsenKantor is a comprehensive office attendance management system that includes:
- **Mobile App (Flutter)**: Employee-facing mobile application for attendance, leave, overtime, and more
- **Backend API (Laravel)**: RESTful API backend with JWT authentication
- **Database Schema**: Complete MySQL database schema for multi-tenant operations

## ✨ Key Features

### Mobile Application
- ✅ **Authentication**: Login with biometric support (fingerprint/face ID)
- ✅ **Dashboard**: Real-time attendance status and statistics
- ✅ **Clock In/Out**: GPS-validated attendance with selfie capture and geofencing
- ✅ **Attendance History**: View and export attendance records
- ✅ **Leave Management**: Submit leave requests and track approvals
- ✅ **Overtime Tracking**: Request and monitor overtime hours
- ✅ **Work Schedule**: View shifts and holiday calendar
- ✅ **Payslips**: Access and download monthly payslips
- ✅ **Profile Management**: Update profile and change password
- ✅ **Notifications**: Real-time push notifications
- ✅ **Offline Mode**: Continue working offline with automatic sync

### Backend API
- ✅ **JWT Authentication**: Secure token-based authentication
- ✅ **Profile Management**: User profile CRUD operations
- ✅ **Attendance API**: Clock in/out with GPS and photo verification
- ✅ **Leave Management**: Leave request workflow with approvals
- ✅ **Overtime Management**: Overtime request and tracking
- ✅ **Schedule Management**: Work shifts and holidays
- ✅ **Payroll System**: Payslip generation and management
- ✅ **Notifications**: Push notification system
- ✅ **Multi-tenant**: Institution-based data separation

## 🛠️ Tech Stack

### Mobile App (Flutter)
- **Framework**: Flutter 3.x with Dart
- **State Management**: BLoC/Cubit pattern
- **HTTP Client**: Dio for API calls
- **Local Storage**: SharedPreferences & SQLite
- **Authentication**: JWT with biometric (local_auth)
- **Camera**: Camera package for selfies
- **Location**: Geolocator & Geocoding
- **Maps**: Google Maps Flutter

### Backend API (Laravel)
- **Framework**: Laravel 10.x (PHP 8.1+)
- **Database**: MySQL
- **Authentication**: JWT (tymon/jwt-auth)
- **Image Processing**: Intervention Image
- **PDF Generation**: DomPDF

## 📁 Project Structure

```
absenkantor/
├── mobile/              # Flutter mobile application
│   ├── lib/
│   │   ├── app/        # App configuration
│   │   ├── config/     # API & app config
│   │   ├── core/       # Core utilities
│   │   ├── data/       # Data layer
│   │   ├── domain/     # Business logic
│   │   └── presentation/ # UI layer
│   ├── android/        # Android-specific code
│   ├── ios/           # iOS-specific code
│   └── pubspec.yaml   # Flutter dependencies
│
├── backend/           # Laravel backend API
│   ├── app/
│   │   ├── Http/      # Controllers & Middleware
│   │   ├── Models/    # Eloquent models
│   │   └── Services/  # Business logic services
│   ├── database/
│   │   └── migrations/ # Database migrations
│   ├── routes/
│   │   └── api.php    # API routes
│   └── composer.json  # PHP dependencies
│
├── database/          # Shared database documentation
│   └── migrations/    # Database migration files
│
└── docs/             # Project documentation
```

## 🚀 Quick Start

### Mobile App Setup

1. Navigate to mobile directory:
```bash
cd mobile
```

2. Install Flutter dependencies:
```bash
flutter pub get
```

3. Configure API endpoint in `lib/config/api_config.dart`:
```dart
static const String baseUrl = 'http://your-api-url/api';
```

4. Run the app:
```bash
flutter run
```

See [mobile/README.md](mobile/README.md) for detailed instructions.

### Backend API Setup

1. Navigate to backend directory:
```bash
cd backend
```

2. Install PHP dependencies:
```bash
composer install
```

3. Configure environment:
```bash
cp .env.example .env
# Edit .env with your database credentials
```

4. Generate keys and run migrations:
```bash
php artisan key:generate
php artisan jwt:secret
php artisan migrate
```

5. Start server:
```bash
php artisan serve
```

See [backend/README.md](backend/README.md) for detailed instructions.

## 📊 Database Schema

The system uses MySQL with a multi-tenant architecture (institution-based). Key tables include:

### Core Tables
- `institutions` - Organizations/companies
- `branches` - Branch offices
- `departments` - Departments
- `positions` - Job positions
- `users` - User accounts
- `employees` - Employee data

### Attendance Tables
- `work_shifts` - Shift definitions
- `attendance_locations` - Valid GPS locations
- `employee_attendances` - Daily records
- `attendance_logs` - Detailed logs
- `attendance_summaries` - Monthly summaries
- `daily_schedules` - Employee schedules

### Leave & Overtime Tables
- `leave_types` - Leave type definitions
- `leave_requests` - Leave applications
- `leave_approvals` - Approval workflow
- `employee_leave_balances` - Leave balances
- `overtime_requests` - Overtime records

### Payroll Tables
- `payroll_periods` - Payroll periods
- `payslips` - Employee payslips
- `payslip_details` - Salary components

### Other Tables
- `notifications` - User notifications
- `announcements` - Company announcements
- `holidays` - Holiday calendar
- `user_sessions` - Session management

## 🔐 Security Features

- JWT token authentication
- Password hashing (bcrypt)
- Biometric authentication (mobile)
- Secure file storage
- CSRF protection
- SQL injection protection
- Rate limiting
- Input validation

## 📖 API Documentation

### Authentication Endpoints
```
POST /api/auth/login          - Login
POST /api/auth/logout         - Logout
POST /api/auth/refresh        - Refresh token
POST /api/auth/forgot-password - Forgot password
POST /api/auth/reset-password - Reset password
```

### Profile Endpoints
```
GET  /api/profile             - Get profile
PUT  /api/profile             - Update profile
PUT  /api/profile/password    - Change password
POST /api/profile/avatar      - Upload avatar
```

### Attendance Endpoints
```
POST /api/attendance/clock-in    - Clock in
POST /api/attendance/clock-out   - Clock out
GET  /api/attendance/today       - Today's attendance
GET  /api/attendance/history     - Attendance history
GET  /api/attendance/summary     - Monthly summary
GET  /api/attendance/locations   - Valid locations
```

### Leave Endpoints
```
GET    /api/leaves          - List leaves
POST   /api/leaves          - Create leave
GET    /api/leaves/{id}     - Leave details
DELETE /api/leaves/{id}     - Cancel leave
GET    /api/leaves/types    - Leave types
GET    /api/leaves/balance  - Leave balance
```

### Other Endpoints
- Overtime management
- Schedule & shifts
- Holidays
- Payslips
- Notifications
- Announcements

Full API documentation is available in [backend/README.md](backend/README.md).

## 🧪 Testing

### Mobile App
```bash
cd mobile
flutter test
```

### Backend API
```bash
cd backend
php artisan test
```

## 📦 Deployment

### Mobile App
```bash
# Android APK
flutter build apk --release

# Android App Bundle
flutter build appbundle --release

# iOS
flutter build ios --release
```

### Backend API
1. Configure production environment
2. Set up web server (Apache/Nginx)
3. Configure SSL certificate
4. Run migrations
5. Set up cron jobs
6. Configure queue workers

## 🤝 Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## 📄 License

This project is licensed under the MIT License.

## 👥 Author

**Ray Fan Satria**

## 🙏 Acknowledgments

- Flutter team for the amazing framework
- Laravel team for the robust backend framework
- All contributors and users of this project

---

**Note**: This is a complete, production-ready office attendance system. For detailed setup instructions, please refer to the README files in the `mobile/` and `backend/` directories.
