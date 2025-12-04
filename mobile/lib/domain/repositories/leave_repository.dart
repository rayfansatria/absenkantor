abstract class LeaveRepository {
  Future<List<dynamic>> getLeaves({int page = 1});
  Future<Map<String, dynamic>> getLeaveDetails(int id);
  Future<Map<String, dynamic>> createLeave(Map<String, dynamic> data);
  Future<void> cancelLeave(int id);
  Future<List<dynamic>> getLeaveTypes();
  Future<Map<String, dynamic>> getLeaveBalance();
}
