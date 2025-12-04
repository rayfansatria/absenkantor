abstract class OvertimeRepository {
  Future<List<dynamic>> getOvertimes({int page = 1});
  Future<Map<String, dynamic>> getOvertimeDetails(int id);
  Future<Map<String, dynamic>> createOvertime(Map<String, dynamic> data);
}
