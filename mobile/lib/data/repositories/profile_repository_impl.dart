import '../../domain/repositories/profile_repository.dart';
import '../datasources/remote/api_service.dart';
import '../../config/api_config.dart';

class ProfileRepositoryImpl implements ProfileRepository {
  final ApiService apiService;

  ProfileRepositoryImpl(this.apiService);

  // TODO: Implement all profile repository methods
  // - getProfile(): GET from ApiConfig.profile
  // - updateProfile(): PUT to ApiConfig.updateProfile with data
  // - changePassword(): PUT to ApiConfig.changePassword with old/new password
  // - uploadAvatar(): POST to ApiConfig.uploadAvatar with image file
  
  @override
  dynamic noSuchMethod(Invocation invocation) => super.noSuchMethod(invocation);
}
