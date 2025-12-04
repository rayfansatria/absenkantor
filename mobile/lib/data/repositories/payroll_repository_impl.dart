import '../../domain/repositories/payroll_repository.dart';
import '../datasources/remote/api_service.dart';

class PayrollRepositoryImpl implements PayrollRepository {
  final ApiService apiService;

  PayrollRepositoryImpl(this.apiService);

  @override
  dynamic noSuchMethod(Invocation invocation) => super.noSuchMethod(invocation);
}
