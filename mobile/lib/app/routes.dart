import 'package:flutter/material.dart';
import '../presentation/pages/splash_page.dart';
import '../presentation/pages/auth/login_page.dart';
import '../presentation/pages/auth/forgot_password_page.dart';
import '../presentation/pages/dashboard/dashboard_page.dart';
import '../presentation/pages/attendance/clock_in_out_page.dart';
import '../presentation/pages/attendance/attendance_history_page.dart';
import '../presentation/pages/leave/leave_list_page.dart';
import '../presentation/pages/leave/leave_form_page.dart';
import '../presentation/pages/overtime/overtime_list_page.dart';
import '../presentation/pages/overtime/overtime_form_page.dart';
import '../presentation/pages/schedule/schedule_page.dart';
import '../presentation/pages/payroll/payslip_list_page.dart';
import '../presentation/pages/profile/profile_page.dart';
import '../presentation/pages/profile/edit_profile_page.dart';
import '../presentation/pages/profile/change_password_page.dart';
import '../presentation/pages/notifications/notifications_page.dart';

class AppRoutes {
  static const String splash = '/';
  static const String login = '/login';
  static const String forgotPassword = '/forgot-password';
  static const String dashboard = '/dashboard';
  static const String clockInOut = '/clock-in-out';
  static const String attendanceHistory = '/attendance-history';
  static const String leaveList = '/leave-list';
  static const String leaveForm = '/leave-form';
  static const String overtimeList = '/overtime-list';
  static const String overtimeForm = '/overtime-form';
  static const String schedule = '/schedule';
  static const String payslipList = '/payslip-list';
  static const String profile = '/profile';
  static const String editProfile = '/edit-profile';
  static const String changePassword = '/change-password';
  static const String notifications = '/notifications';

  static Route<dynamic> onGenerateRoute(RouteSettings settings) {
    switch (settings.name) {
      case splash:
        return MaterialPageRoute(builder: (_) => const SplashPage());
      case login:
        return MaterialPageRoute(builder: (_) => const LoginPage());
      case forgotPassword:
        return MaterialPageRoute(builder: (_) => const ForgotPasswordPage());
      case dashboard:
        return MaterialPageRoute(builder: (_) => const DashboardPage());
      case clockInOut:
        return MaterialPageRoute(builder: (_) => const ClockInOutPage());
      case attendanceHistory:
        return MaterialPageRoute(builder: (_) => const AttendanceHistoryPage());
      case leaveList:
        return MaterialPageRoute(builder: (_) => const LeaveListPage());
      case leaveForm:
        return MaterialPageRoute(builder: (_) => const LeaveFormPage());
      case overtimeList:
        return MaterialPageRoute(builder: (_) => const OvertimeListPage());
      case overtimeForm:
        return MaterialPageRoute(builder: (_) => const OvertimeFormPage());
      case schedule:
        return MaterialPageRoute(builder: (_) => const SchedulePage());
      case payslipList:
        return MaterialPageRoute(builder: (_) => const PayslipListPage());
      case profile:
        return MaterialPageRoute(builder: (_) => const ProfilePage());
      case editProfile:
        return MaterialPageRoute(builder: (_) => const EditProfilePage());
      case changePassword:
        return MaterialPageRoute(builder: (_) => const ChangePasswordPage());
      case notifications:
        return MaterialPageRoute(builder: (_) => const NotificationsPage());
      default:
        return MaterialPageRoute(
          builder: (_) => Scaffold(
            body: Center(
              child: Text('No route defined for ${settings.name}'),
            ),
          ),
        );
    }
  }
}
