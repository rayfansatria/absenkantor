import 'package:shared_preferences/shared_preferences.dart';
import '../../../config/app_config.dart';

class LocalStorage {
  final SharedPreferences sharedPreferences;

  LocalStorage(this.sharedPreferences);

  Future<void> saveToken(String token) async {
    await sharedPreferences.setString(AppConfig.keyAuthToken, token);
  }

  Future<String?> getToken() async {
    return sharedPreferences.getString(AppConfig.keyAuthToken);
  }

  Future<void> removeToken() async {
    await sharedPreferences.remove(AppConfig.keyAuthToken);
  }

  Future<void> saveUserData(String userData) async {
    await sharedPreferences.setString(AppConfig.keyUserData, userData);
  }

  Future<String?> getUserData() async {
    return sharedPreferences.getString(AppConfig.keyUserData);
  }

  Future<void> clear() async {
    await sharedPreferences.clear();
  }
}
