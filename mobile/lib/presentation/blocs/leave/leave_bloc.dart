import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:equatable/equatable.dart';
import '../../../domain/repositories/leave_repository.dart';

abstract class LeaveEvent extends Equatable {
  @override
  List<Object?> get props => [];
}

abstract class LeaveState extends Equatable {
  @override
  List<Object?> get props => [];
}

class LeaveInitial extends LeaveState {}

class LeaveBloc extends Bloc<LeaveEvent, LeaveState> {
  final LeaveRepository leaveRepository;
  LeaveBloc(this.leaveRepository) : super(LeaveInitial());
}
