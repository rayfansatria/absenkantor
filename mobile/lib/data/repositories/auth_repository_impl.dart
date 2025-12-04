import '../../domain/repositories/auth_repository.dart';
import '../../domain/entities/user.dart';
import '../datasources/remote/api_service.dart';
import '../datasources/local/local_storage.dart';
import '../models/user_model.dart';
import '../../config/api_config.dart';

class AuthRepositoryImpl implements AuthRepository {
  final ApiService apiService;
  final LocalStorage localStorage;

  AuthRepositoryImpl(this.apiService, this.localStorage);

  @override
  Future<Map<String, dynamic>> login({
    required String username,
    required String password,
    bool rememberMe = false,
  }) async {
    try {
      final response = await apiService.post(ApiConfig.login, data: {
        'username': username,
        'password': password,
      });

      if (response.statusCode == 200) {
        final data = response.data;
        final token = data['token'];
        final userModel = UserModel.fromJson(data['user']);

        await localStorage.saveToken(token);
        await localStorage.saveUserData(userModel.toRawJson());

        return {
          'success': true,
          'user': userModel.toEntity(),
          'token': token,
        };
      }

      return {'success': false, 'message': 'Login failed'};
    } catch (e) {
      return {'success': false, 'message': e.toString()};
    }
  }

  @override
  Future<void> logout() async {
    try {
      await apiService.post(ApiConfig.logout);
    } finally {
      await localStorage.clear();
    }
  }

  @override
  Future<bool> isLoggedIn() async {
    final token = await localStorage.getToken();
    return token != null;
  }

  @override
  Future<User?> getCurrentUser() async {
    final userData = await localStorage.getUserData();
    if (userData != null) {
      final userModel = UserModel.fromRawJson(userData);
      return userModel.toEntity();
    }
    return null;
  }

  @override
  Future<String?> getToken() async {
    return await localStorage.getToken();
  }

  @override
  Future<String?> refreshToken() async {
    try {
      final response = await apiService.post(ApiConfig.refresh);
      if (response.statusCode == 200) {
        final newToken = response.data['token'];
        await localStorage.saveToken(newToken);
        return newToken;
      }
    } catch (e) {
      // Log error and return null to indicate failure
      print('Error refreshing token: $e');
      // In production, use proper logging service
    }
    return null;
  }
}
