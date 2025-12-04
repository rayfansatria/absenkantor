import '../../domain/repositories/payroll_repository.dart';
import '../datasources/remote/api_service.dart';
import '../../config/api_config.dart';

class PayrollRepositoryImpl implements PayrollRepository {
  final ApiService apiService;

  PayrollRepositoryImpl(this.apiService);

  // TODO: Implement all payroll repository methods
  // - getPayslips(): GET from ApiConfig.payslips with pagination
  // - getPayslipDetails(): GET from ApiConfig.payslips/{id}
  // - downloadPayslip(): GET from ApiConfig.payslips/{id}/download
  
  @override
  dynamic noSuchMethod(Invocation invocation) {
    throw UnimplementedError(
      'Method ${invocation.memberName} is not yet implemented in PayrollRepositoryImpl. '
      'Please implement this method according to the TODO comments above.'
    );
  }
}
