import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:equatable/equatable.dart';
import '../../../domain/repositories/attendance_repository.dart';

// TODO: Implement attendance events
// - ClockInEvent
// - ClockOutEvent
// - LoadAttendanceHistoryEvent
// - LoadAttendanceSummaryEvent
abstract class AttendanceEvent extends Equatable {
  @override
  List<Object?> get props => [];
}

// TODO: Implement attendance states
// - AttendanceLoading
// - AttendanceLoaded
// - AttendanceError
// - ClockInSuccess
// - ClockOutSuccess
abstract class AttendanceState extends Equatable {
  @override
  List<Object?> get props => [];
}

class AttendanceInitial extends AttendanceState {}

class AttendanceBloc extends Bloc<AttendanceEvent, AttendanceState> {
  final AttendanceRepository attendanceRepository;

  AttendanceBloc(this.attendanceRepository) : super(AttendanceInitial());
  
  // TODO: Add event handlers
  // on<ClockInEvent>(_onClockIn);
  // on<ClockOutEvent>(_onClockOut);
  // on<LoadAttendanceHistoryEvent>(_onLoadHistory);
}
