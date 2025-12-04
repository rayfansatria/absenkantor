abstract class ProfileRepository {
  Future<Map<String, dynamic>> getProfile();
  Future<Map<String, dynamic>> updateProfile(Map<String, dynamic> data);
  Future<void> changePassword(String oldPassword, String newPassword);
  Future<String> uploadAvatar(String filePath);
}
