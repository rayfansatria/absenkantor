#!/bin/bash

# Create repository implementations
cd lib/data/repositories

cat > auth_repository_impl.dart << 'EOF'
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
      // Handle error
    }
    return null;
  }
}
EOF

# Create stub repository implementations
for repo in attendance leave overtime profile schedule payroll; do
  repo_cap="$(tr '[:lower:]' '[:upper:]' <<< ${repo:0:1})${repo:1}"
  cat > ${repo}_repository_impl.dart << EOF
import '../../domain/repositories/${repo}_repository.dart';
import '../datasources/remote/api_service.dart';

class ${repo_cap}RepositoryImpl implements ${repo_cap}Repository {
  final ApiService apiService;

  ${repo_cap}RepositoryImpl(this.apiService);

  @override
  dynamic noSuchMethod(Invocation invocation) => super.noSuchMethod(invocation);
}
EOF
done

cd ../../..
echo "Repositories created"
