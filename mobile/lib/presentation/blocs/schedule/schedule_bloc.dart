import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:equatable/equatable.dart';
import '../../../domain/repositories/schedule_repository.dart';

abstract class ScheduleEvent extends Equatable {
  @override
  List<Object?> get props => [];
}

abstract class ScheduleState extends Equatable {
  @override
  List<Object?> get props => [];
}

class ScheduleInitial extends ScheduleState {}

class ScheduleBloc extends Bloc<ScheduleEvent, ScheduleState> {
  final ScheduleRepository scheduleRepository;
  ScheduleBloc(this.scheduleRepository) : super(ScheduleInitial());
}
