import '../../domain/repositories/overtime_repository.dart';
import '../datasources/remote/api_service.dart';
import '../../config/api_config.dart';

class OvertimeRepositoryImpl implements OvertimeRepository {
  final ApiService apiService;

  OvertimeRepositoryImpl(this.apiService);

  // TODO: Implement all overtime repository methods
  // - getOvertimes(): GET from ApiConfig.overtimes with pagination
  // - getOvertimeDetails(): GET from ApiConfig.overtimes/{id}
  // - createOvertime(): POST to ApiConfig.overtimes with request data
  
  @override
  dynamic noSuchMethod(Invocation invocation) => super.noSuchMethod(invocation);
}
