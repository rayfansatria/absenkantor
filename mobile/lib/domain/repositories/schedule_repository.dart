abstract class ScheduleRepository {
  Future<List<dynamic>> getSchedules(DateTime startDate, DateTime endDate);
  Future<List<dynamic>> getShifts();
  Future<List<dynamic>> getHolidays(int year);
}
