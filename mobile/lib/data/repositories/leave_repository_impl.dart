import '../../domain/repositories/leave_repository.dart';
import '../datasources/remote/api_service.dart';
import '../../config/api_config.dart';

class LeaveRepositoryImpl implements LeaveRepository {
  final ApiService apiService;

  LeaveRepositoryImpl(this.apiService);

  // TODO: Implement all leave repository methods
  // - getLeaves(): GET from ApiConfig.leaves with pagination
  // - getLeaveDetails(): GET from ApiConfig.leaves/{id}
  // - createLeave(): POST to ApiConfig.leaves with form data
  // - cancelLeave(): DELETE to ApiConfig.leaves/{id}
  // - getLeaveTypes(): GET from ApiConfig.leaveTypes
  // - getLeaveBalance(): GET from ApiConfig.leaveBalance
  
  @override
  dynamic noSuchMethod(Invocation invocation) {
    throw UnimplementedError(
      'Method ${invocation.memberName} is not yet implemented in LeaveRepositoryImpl. '
      'Please implement this method according to the TODO comments above.'
    );
  }
}
