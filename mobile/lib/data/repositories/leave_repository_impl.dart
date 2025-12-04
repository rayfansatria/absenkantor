import '../../domain/repositories/leave_repository.dart';
import '../datasources/remote/api_service.dart';

class LeaveRepositoryImpl implements LeaveRepository {
  final ApiService apiService;

  LeaveRepositoryImpl(this.apiService);

  @override
  dynamic noSuchMethod(Invocation invocation) => super.noSuchMethod(invocation);
}
