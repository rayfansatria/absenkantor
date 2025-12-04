class AppConfig {
  // App Info
  static const String appName = 'AbsenKantor';
  static const String appVersion = '1.0.0';
  
  // Storage Keys
  static const String keyAuthToken = 'auth_token';
  static const String keyRefreshToken = 'refresh_token';
  static const String keyUserId = 'user_id';
  static const String keyUserData = 'user_data';
  static const String keyRememberMe = 'remember_me';
  static const String keyBiometricEnabled = 'biometric_enabled';
  static const String keyNotificationEnabled = 'notification_enabled';
  static const String keyDarkMode = 'dark_mode';
  
  // Geofencing
  static const double defaultGeofenceRadius = 100.0; // meters
  
  // Camera
  static const int maxImageSize = 2048; // pixels
  static const int imageQuality = 85; // 0-100
  
  // Pagination
  static const int defaultPageSize = 20;
  
  // Date Format
  static const String dateFormat = 'dd/MM/yyyy';
  static const String timeFormat = 'HH:mm';
  static const String dateTimeFormat = 'dd/MM/yyyy HH:mm';
  
  // Language
  static const String defaultLanguage = 'id';
}
