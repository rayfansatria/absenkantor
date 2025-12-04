import 'package:get_it/get_it.dart';
import 'package:shared_preferences/shared_preferences.dart';
import 'package:dio/dio.dart';
import '../../data/datasources/local/local_storage.dart';
import '../../data/datasources/remote/api_service.dart';
import '../../data/repositories/auth_repository_impl.dart';
import '../../data/repositories/attendance_repository_impl.dart';
import '../../data/repositories/leave_repository_impl.dart';
import '../../data/repositories/overtime_repository_impl.dart';
import '../../data/repositories/profile_repository_impl.dart';
import '../../data/repositories/schedule_repository_impl.dart';
import '../../data/repositories/payroll_repository_impl.dart';
import '../../domain/repositories/auth_repository.dart';
import '../../domain/repositories/attendance_repository.dart';
import '../../domain/repositories/leave_repository.dart';
import '../../domain/repositories/overtime_repository.dart';
import '../../domain/repositories/profile_repository.dart';
import '../../domain/repositories/schedule_repository.dart';
import '../../domain/repositories/payroll_repository.dart';
import '../../presentation/blocs/auth/auth_bloc.dart';
import '../../presentation/blocs/attendance/attendance_bloc.dart';
import '../../presentation/blocs/leave/leave_bloc.dart';
import '../../presentation/blocs/overtime/overtime_bloc.dart';
import '../../presentation/blocs/profile/profile_bloc.dart';
import '../../presentation/blocs/schedule/schedule_bloc.dart';
import '../../presentation/blocs/payroll/payroll_bloc.dart';

final getIt = GetIt.instance;

Future<void> setupServiceLocator() async {
  // External
  final sharedPreferences = await SharedPreferences.getInstance();
  getIt.registerSingleton<SharedPreferences>(sharedPreferences);
  
  final dio = Dio();
  getIt.registerSingleton<Dio>(dio);
  
  // Core
  getIt.registerLazySingleton<LocalStorage>(
    () => LocalStorage(getIt<SharedPreferences>()),
  );
  
  getIt.registerLazySingleton<ApiService>(
    () => ApiService(getIt<Dio>(), getIt<LocalStorage>()),
  );
  
  // Repositories
  getIt.registerLazySingleton<AuthRepository>(
    () => AuthRepositoryImpl(getIt<ApiService>(), getIt<LocalStorage>()),
  );
  
  getIt.registerLazySingleton<AttendanceRepository>(
    () => AttendanceRepositoryImpl(getIt<ApiService>()),
  );
  
  getIt.registerLazySingleton<LeaveRepository>(
    () => LeaveRepositoryImpl(getIt<ApiService>()),
  );
  
  getIt.registerLazySingleton<OvertimeRepository>(
    () => OvertimeRepositoryImpl(getIt<ApiService>()),
  );
  
  getIt.registerLazySingleton<ProfileRepository>(
    () => ProfileRepositoryImpl(getIt<ApiService>()),
  );
  
  getIt.registerLazySingleton<ScheduleRepository>(
    () => ScheduleRepositoryImpl(getIt<ApiService>()),
  );
  
  getIt.registerLazySingleton<PayrollRepository>(
    () => PayrollRepositoryImpl(getIt<ApiService>()),
  );
  
  // BLoCs
  getIt.registerFactory<AuthBloc>(
    () => AuthBloc(getIt<AuthRepository>()),
  );
  
  getIt.registerFactory<AttendanceBloc>(
    () => AttendanceBloc(getIt<AttendanceRepository>()),
  );
  
  getIt.registerFactory<LeaveBloc>(
    () => LeaveBloc(getIt<LeaveRepository>()),
  );
  
  getIt.registerFactory<OvertimeBloc>(
    () => OvertimeBloc(getIt<OvertimeRepository>()),
  );
  
  getIt.registerFactory<ProfileBloc>(
    () => ProfileBloc(getIt<ProfileRepository>()),
  );
  
  getIt.registerFactory<ScheduleBloc>(
    () => ScheduleBloc(getIt<ScheduleRepository>()),
  );
  
  getIt.registerFactory<PayrollBloc>(
    () => PayrollBloc(getIt<PayrollRepository>()),
  );
}
