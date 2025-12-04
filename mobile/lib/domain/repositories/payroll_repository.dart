abstract class PayrollRepository {
  Future<List<dynamic>> getPayslips({int page = 1});
  Future<Map<String, dynamic>> getPayslipDetails(int id);
  Future<String> downloadPayslip(int id);
}
