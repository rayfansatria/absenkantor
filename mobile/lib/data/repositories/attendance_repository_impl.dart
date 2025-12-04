import '../../domain/repositories/attendance_repository.dart';
import '../datasources/remote/api_service.dart';
import '../../config/api_config.dart';

class AttendanceRepositoryImpl implements AttendanceRepository {
  final ApiService apiService;

  AttendanceRepositoryImpl(this.apiService);

  // TODO: Implement all attendance repository methods
  // - clockIn(): POST to ApiConfig.clockIn with photo, GPS, notes
  // - clockOut(): POST to ApiConfig.clockOut with photo, GPS, notes
  // - getTodayAttendance(): GET from ApiConfig.attendanceToday
  // - getAttendanceHistory(): GET from ApiConfig.attendanceHistory
  // - getAttendanceSummary(): GET from ApiConfig.attendanceSummary
  
  @override
  dynamic noSuchMethod(Invocation invocation) => super.noSuchMethod(invocation);
}
