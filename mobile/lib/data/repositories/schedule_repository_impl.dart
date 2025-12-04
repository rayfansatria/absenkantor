import '../../domain/repositories/schedule_repository.dart';
import '../datasources/remote/api_service.dart';

class ScheduleRepositoryImpl implements ScheduleRepository {
  final ApiService apiService;

  ScheduleRepositoryImpl(this.apiService);

  @override
  dynamic noSuchMethod(Invocation invocation) => super.noSuchMethod(invocation);
}
