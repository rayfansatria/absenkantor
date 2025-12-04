import '../../domain/repositories/attendance_repository.dart';
import '../datasources/remote/api_service.dart';

class AttendanceRepositoryImpl implements AttendanceRepository {
  final ApiService apiService;

  AttendanceRepositoryImpl(this.apiService);

  @override
  dynamic noSuchMethod(Invocation invocation) => super.noSuchMethod(invocation);
}
