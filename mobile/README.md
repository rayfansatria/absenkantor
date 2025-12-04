# AbsenKantor Mobile App

Office attendance mobile application built with Flutter.

## Features

### 1. Authentication
- Login with username/email & password
- Biometric authentication (fingerprint/face ID)
- Remember me / Auto login
- Forgot password
- Session management

### 2. Dashboard
- Today's attendance summary
- Clock in/out status
- Monthly statistics (present, late, leave, etc.)
- Latest announcements
- Quick actions

### 3. Clock In/Out (Attendance)
- GPS validation with geofencing
- Selfie capture with camera
- Location display
- Notes for attendance
- Multiple attendance locations support
- Late/early leave indicators
- Offline mode with auto sync

### 4. Attendance History
- Monthly attendance list
- Filter by status
- Attendance details (time, location, photo)
- Export/download reports

### 5. Leave Management
- Available leave types
- Leave request form with dates & reason
- Upload supporting documents
- Select delegate employee
- Request history & approval status
- Leave balance display

### 6. Overtime Management
- Overtime request form
- Request history & status
- Overtime compensation details

### 7. Work Schedule
- Weekly/monthly shift view
- Calendar with holidays
- Schedule change notifications

### 8. Payroll/Payslip
- Monthly payslip list
- Salary component details (earnings & deductions)
- Download PDF

### 9. Profile & Settings
- View & edit profile
- Change password
- Notification settings
- Biometric settings
- Logout

### 10. Notifications
- Attendance reminders
- Leave/overtime approval notifications
- Announcement notifications

## Tech Stack

- **Framework**: Flutter 3.x with Dart
- **State Management**: BLoC/Cubit
- **HTTP Client**: Dio
- **Local Storage**: SharedPreferences & SQLite
- **Biometric**: local_auth package
- **Camera**: camera package
- **Location**: geolocator & geocoding packages
- **Maps**: google_maps_flutter

## Setup Instructions

### Prerequisites

- Flutter SDK (3.0.0 or higher)
- Dart SDK (3.0.0 or higher)
- Android Studio / VS Code with Flutter extensions
- iOS: Xcode (for iOS development)
- Android: Android SDK

### Installation

1. Clone the repository:
```bash
git clone https://github.com/rayfansatria/absenkantor.git
cd absenkantor/mobile
```

2. Install dependencies:
```bash
flutter pub get
```

3. Configure API endpoint:
Edit `lib/config/api_config.dart` and set your API base URL:
```dart
static const String baseUrl = 'http://your-api-url/api';
```

4. Run the app:
```bash
# For Android
flutter run

# For iOS
flutter run -d ios

# For a specific device
flutter devices
flutter run -d <device-id>
```

### Build

#### Android APK
```bash
flutter build apk --release
```

#### Android App Bundle
```bash
flutter build appbundle --release
```

#### iOS
```bash
flutter build ios --release
```

## Project Structure

```
lib/
├── main.dart
├── app/
│   ├── app.dart                 # App root widget
│   ├── routes.dart              # Navigation routes
│   └── theme.dart               # App theme
├── config/
│   ├── api_config.dart          # API configuration
│   └── app_config.dart          # App configuration
├── core/
│   ├── constants/               # App constants
│   ├── errors/                  # Error handling
│   ├── network/                 # Network utilities
│   ├── utils/                   # Utility functions
│   └── widgets/                 # Reusable widgets
├── data/
│   ├── datasources/            # Data sources (local & remote)
│   ├── models/                 # Data models
│   └── repositories/           # Repository implementations
├── domain/
│   ├── entities/               # Business entities
│   ├── repositories/           # Repository interfaces
│   └── usecases/               # Business use cases
└── presentation/
    ├── blocs/                  # BLoC state management
    ├── pages/                  # App pages/screens
    └── widgets/                # Page-specific widgets
```

## Configuration

### API Configuration

Edit `lib/config/api_config.dart`:
```dart
class ApiConfig {
  static const String baseUrl = 'http://your-api-url/api';
  // ... other configurations
}
```

### App Configuration

Edit `lib/config/app_config.dart`:
```dart
class AppConfig {
  static const String appName = 'AbsenKantor';
  static const String appVersion = '1.0.0';
  // ... other configurations
}
```

## Testing

Run tests:
```bash
flutter test
```

Run tests with coverage:
```bash
flutter test --coverage
```

## Troubleshooting

### Common Issues

1. **Flutter SDK not found**
   - Make sure Flutter is installed and added to your PATH
   - Run `flutter doctor` to check your Flutter installation

2. **Dependencies not found**
   - Run `flutter pub get` to install dependencies

3. **Build errors**
   - Clean the build: `flutter clean`
   - Re-install dependencies: `flutter pub get`
   - Try building again

## License

This project is licensed under the MIT License.
