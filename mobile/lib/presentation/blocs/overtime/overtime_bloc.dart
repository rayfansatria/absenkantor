import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:equatable/equatable.dart';
import '../../../domain/repositories/overtime_repository.dart';

abstract class OvertimeEvent extends Equatable {
  @override
  List<Object?> get props => [];
}

abstract class OvertimeState extends Equatable {
  @override
  List<Object?> get props => [];
}

class OvertimeInitial extends OvertimeState {}

class OvertimeBloc extends Bloc<OvertimeEvent, OvertimeState> {
  final OvertimeRepository overtimeRepository;
  OvertimeBloc(this.overtimeRepository) : super(OvertimeInitial());
}
