import '../../domain/repositories/schedule_repository.dart';
import '../datasources/remote/api_service.dart';
import '../../config/api_config.dart';

class ScheduleRepositoryImpl implements ScheduleRepository {
  final ApiService apiService;

  ScheduleRepositoryImpl(this.apiService);

  // TODO: Implement all schedule repository methods
  // - getSchedules(): GET from ApiConfig.schedules with date range
  // - getShifts(): GET from ApiConfig.shifts
  // - getHolidays(): GET from ApiConfig.holidays with year
  
  @override
  dynamic noSuchMethod(Invocation invocation) => super.noSuchMethod(invocation);
}
