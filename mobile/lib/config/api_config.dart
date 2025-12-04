class ApiConfig {
  // Base URL - Change this to your API URL
  static const String baseUrl = 'http://localhost:8000/api';
  
  // Endpoints
  // Auth
  static const String login = '/auth/login';
  static const String logout = '/auth/logout';
  static const String refresh = '/auth/refresh';
  static const String forgotPassword = '/auth/forgot-password';
  static const String resetPassword = '/auth/reset-password';
  
  // Profile
  static const String profile = '/profile';
  static const String updateProfile = '/profile';
  static const String changePassword = '/profile/password';
  static const String uploadAvatar = '/profile/avatar';
  
  // Attendance
  static const String clockIn = '/attendance/clock-in';
  static const String clockOut = '/attendance/clock-out';
  static const String attendanceToday = '/attendance/today';
  static const String attendanceHistory = '/attendance/history';
  static const String attendanceSummary = '/attendance/summary';
  static const String attendanceLocations = '/attendance/locations';
  
  // Leave
  static const String leaves = '/leaves';
  static const String leaveTypes = '/leaves/types';
  static const String leaveBalance = '/leaves/balance';
  
  // Overtime
  static const String overtimes = '/overtimes';
  
  // Schedule
  static const String schedules = '/schedules';
  static const String shifts = '/schedules/shifts';
  static const String holidays = '/holidays';
  
  // Payroll
  static const String payslips = '/payslips';
  
  // Notifications
  static const String notifications = '/notifications';
  static const String readNotification = '/notifications/{id}/read';
  static const String readAllNotifications = '/notifications/read-all';
  
  // Announcements
  static const String announcements = '/announcements';
  
  // Timeout
  static const Duration connectTimeout = Duration(seconds: 30);
  static const Duration receiveTimeout = Duration(seconds: 30);
}
