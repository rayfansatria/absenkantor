import '../../domain/repositories/overtime_repository.dart';
import '../datasources/remote/api_service.dart';

class OvertimeRepositoryImpl implements OvertimeRepository {
  final ApiService apiService;

  OvertimeRepositoryImpl(this.apiService);

  @override
  dynamic noSuchMethod(Invocation invocation) => super.noSuchMethod(invocation);
}
