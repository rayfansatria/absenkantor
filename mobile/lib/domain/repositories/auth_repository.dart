import '../entities/user.dart';

abstract class AuthRepository {
  Future<Map<String, dynamic>> login({
    required String username,
    required String password,
    bool rememberMe = false,
  });
  Future<void> logout();
  Future<bool> isLoggedIn();
  Future<User?> getCurrentUser();
  Future<String?> getToken();
  Future<String?> refreshToken();
}
