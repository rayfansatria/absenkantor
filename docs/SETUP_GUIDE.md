# AbsenKantor Setup Guide

Complete setup guide for the AbsenKantor office attendance system.

## System Requirements

### Flutter Mobile App
- Flutter SDK 3.0.0 or higher
- Dart SDK 3.0.0 or higher
- Android Studio or VS Code with Flutter extensions
- For Android: Android SDK (API level 21 or higher)
- For iOS: Xcode 12.0 or higher, CocoaPods

### Laravel Backend
- PHP 8.1 or higher
- Composer 2.x
- MySQL 5.7+ or MariaDB 10.3+
- Node.js 14+ and NPM (for asset compilation)
- Git

## Backend Setup

### 1. Clone Repository
```bash
git clone https://github.com/rayfansatria/absenkantor.git
cd absenkantor/backend
```

### 2. Install PHP Dependencies
```bash
composer install
```

If you encounter memory issues:
```bash
php -d memory_limit=-1 /usr/local/bin/composer install
```

### 3. Environment Configuration
```bash
cp .env.example .env
```

Edit `.env` file with your configuration:
```env
APP_NAME=AbsenKantor
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_absensi_general
DB_USERNAME=root
DB_PASSWORD=your_password_here

JWT_SECRET=
JWT_TTL=60
JWT_REFRESH_TTL=20160
```

### 4. Generate Application Key
```bash
php artisan key:generate
```

### 5. Install JWT Package
```bash
composer require tymon/jwt-auth
php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\LaravelServiceProvider"
php artisan jwt:secret
```

### 6. Create Database
Create a MySQL database:
```sql
CREATE DATABASE db_absensi_general CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 7. Run Migrations
```bash
php artisan migrate
```

If migrations are not in the app's database folder, copy them:
```bash
cp -r ../database/migrations/* database/migrations/
php artisan migrate
```

### 8. (Optional) Seed Database
Create a seeder or manually insert test data:
```bash
php artisan db:seed
```

### 9. Create Storage Link
```bash
php artisan storage:link
```

This creates a symbolic link from `public/storage` to `storage/app/public`.

### 10. Set Permissions
```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

### 11. Start Development Server
```bash
php artisan serve
```

The API will be available at `http://localhost:8000`

Test the API:
```bash
curl http://localhost:8000/api/auth/login
```

## Mobile App Setup

### 1. Navigate to Mobile Directory
```bash
cd ../mobile
```

### 2. Check Flutter Installation
```bash
flutter doctor
```

Fix any issues reported by flutter doctor.

### 3. Install Dependencies
```bash
flutter pub get
```

### 4. Configure API Endpoint
Edit `lib/config/api_config.dart`:
```dart
class ApiConfig {
  static const String baseUrl = 'http://10.0.2.2:8000/api'; // Android Emulator
  // OR
  static const String baseUrl = 'http://localhost:8000/api'; // iOS Simulator
  // OR
  static const String baseUrl = 'http://YOUR_IP:8000/api'; // Real Device
  
  // ... rest of the configuration
}
```

**Important**: 
- For Android Emulator: Use `10.0.2.2` instead of `localhost`
- For iOS Simulator: Use `localhost`
- For Real Device: Use your computer's IP address

### 5. Run the App

#### Android
```bash
# List available devices
flutter devices

# Run on connected device
flutter run

# Or specify device
flutter run -d <device-id>
```

#### iOS (macOS only)
```bash
# Install pods
cd ios
pod install
cd ..

# Run on simulator
flutter run

# Or open in Xcode
open ios/Runner.xcworkspace
```

### 6. Build Release

#### Android APK
```bash
flutter build apk --release
```
Output: `build/app/outputs/flutter-apk/app-release.apk`

#### Android App Bundle
```bash
flutter build appbundle --release
```
Output: `build/app/outputs/bundle/release/app-release.aab`

#### iOS
```bash
flutter build ios --release
```
Then open Xcode and archive.

## Testing

### Backend Tests
```bash
cd backend
php artisan test
```

### Mobile Tests
```bash
cd mobile
flutter test
```

## Troubleshooting

### Backend Issues

#### Database Connection Error
- Check MySQL is running: `systemctl status mysql`
- Verify credentials in `.env`
- Check database exists: `SHOW DATABASES;`

#### JWT Token Error
- Regenerate JWT secret: `php artisan jwt:secret`
- Clear config cache: `php artisan config:clear`

#### Permission Denied
```bash
sudo chown -R $USER:www-data storage
sudo chown -R $USER:www-data bootstrap/cache
chmod -R 775 storage bootstrap/cache
```

### Mobile Issues

#### Flutter Not Found
```bash
# Add Flutter to PATH (Linux/macOS)
export PATH="$PATH:`pwd`/flutter/bin"

# Verify
flutter --version
```

#### Dependencies Error
```bash
flutter clean
flutter pub get
```

#### Android Build Error
```bash
cd android
./gradlew clean
cd ..
flutter build apk
```

#### iOS Build Error
```bash
cd ios
pod deintegrate
pod install
cd ..
flutter clean
flutter build ios
```

#### API Connection Error
- Check API URL in `api_config.dart`
- For emulator, use `10.0.2.2` instead of `localhost`
- Test API endpoint in browser first
- Check firewall settings

## Production Deployment

### Backend (Laravel)

1. **Server Requirements**
   - Ubuntu 20.04+ or similar
   - Nginx or Apache
   - PHP 8.1+ with extensions
   - MySQL/MariaDB
   - SSL certificate

2. **Deploy Steps**
```bash
# Pull code
git pull origin main

# Install dependencies
composer install --no-dev --optimize-autoloader

# Run migrations
php artisan migrate --force

# Clear caches
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Set permissions
chown -R www-data:www-data storage bootstrap/cache
```

3. **Environment**
```env
APP_ENV=production
APP_DEBUG=false
```

4. **Queue Workers** (use Supervisor)
```bash
php artisan queue:work --daemon
```

5. **Cron Jobs**
```
* * * * * cd /path-to-app && php artisan schedule:run >> /dev/null 2>&1
```

### Mobile App

1. **Android**
   - Generate signed APK/AAB
   - Upload to Google Play Console
   - Follow Play Store guidelines

2. **iOS**
   - Create archive in Xcode
   - Upload to App Store Connect
   - Follow App Store guidelines

## Next Steps

1. **Create Test Users**
   - Create database seeder with test data
   - Or manually insert users in database

2. **Configure Google Maps**
   - Get API key from Google Cloud Console
   - Add to Android and iOS configurations

3. **Setup Push Notifications**
   - Configure Firebase
   - Add google-services.json (Android)
   - Add GoogleService-Info.plist (iOS)

4. **Customize Branding**
   - Update app icons
   - Change app name
   - Modify theme colors

## Support

For issues or questions:
- Check documentation in `/docs`
- Review API documentation
- Check GitHub issues
- Contact development team

## License

MIT License - See LICENSE file for details
