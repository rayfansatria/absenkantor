import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:equatable/equatable.dart';
import '../../../domain/repositories/payroll_repository.dart';

abstract class PayrollEvent extends Equatable {
  @override
  List<Object?> get props => [];
}

abstract class PayrollState extends Equatable {
  @override
  List<Object?> get props => [];
}

class PayrollInitial extends PayrollState {}

class PayrollBloc extends Bloc<PayrollEvent, PayrollState> {
  final PayrollRepository payrollRepository;
  PayrollBloc(this.payrollRepository) : super(PayrollInitial());
}
