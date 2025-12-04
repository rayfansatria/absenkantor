abstract class AttendanceRepository {
  Future<Map<String, dynamic>> clockIn({
    required double latitude,
    required double longitude,
    required String photo,
    String? notes,
  });
  Future<Map<String, dynamic>> clockOut({
    required double latitude,
    required double longitude,
    required String photo,
    String? notes,
  });
  Future<Map<String, dynamic>> getTodayAttendance();
  Future<List<dynamic>> getAttendanceHistory({int page = 1});
  Future<Map<String, dynamic>> getAttendanceSummary(int month, int year);
}
