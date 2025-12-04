import 'package:dio/dio.dart';
import '../local/local_storage.dart';
import '../../../config/api_config.dart';

class ApiService {
  final Dio dio;
  final LocalStorage localStorage;

  ApiService(this.dio, this.localStorage) {
    dio.options.baseUrl = ApiConfig.baseUrl;
    dio.options.connectTimeout = ApiConfig.connectTimeout;
    dio.options.receiveTimeout = ApiConfig.receiveTimeout;

    dio.interceptors.add(InterceptorsWrapper(
      onRequest: (options, handler) async {
        final token = await localStorage.getToken();
        if (token != null) {
          options.headers['Authorization'] = 'Bearer $token';
        }
        return handler.next(options);
      },
      onError: (DioException error, handler) async {
        if (error.response?.statusCode == 401) {
          // Token expired, try refresh
          // TODO: Implement token refresh
        }
        return handler.next(error);
      },
    ));
  }

  Future<Response> get(String path, {Map<String, dynamic>? queryParameters}) {
    return dio.get(path, queryParameters: queryParameters);
  }

  Future<Response> post(String path, {dynamic data}) {
    return dio.post(path, data: data);
  }

  Future<Response> put(String path, {dynamic data}) {
    return dio.put(path, data: data);
  }

  Future<Response> delete(String path) {
    return dio.delete(path);
  }
}
