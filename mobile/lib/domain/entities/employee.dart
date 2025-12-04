import 'package:equatable/equatable.dart';

class Employee extends Equatable {
  final int id;
  final String employeeNumber;
  final String fullName;
  final String? email;
  final String? phone;
  final String? address;
  final DateTime? dateOfBirth;
  final String? gender;
  final int? departmentId;
  final String? departmentName;
  final int? positionId;
  final String? positionName;
  final int? branchId;
  final String? branchName;
  final DateTime? joinDate;
  final String? status;

  const Employee({
    required this.id,
    required this.employeeNumber,
    required this.fullName,
    this.email,
    this.phone,
    this.address,
    this.dateOfBirth,
    this.gender,
    this.departmentId,
    this.departmentName,
    this.positionId,
    this.positionName,
    this.branchId,
    this.branchName,
    this.joinDate,
    this.status,
  });

  @override
  List<Object?> get props => [
        id,
        employeeNumber,
        fullName,
        email,
        phone,
        address,
        dateOfBirth,
        gender,
        departmentId,
        departmentName,
        positionId,
        positionName,
        branchId,
        branchName,
        joinDate,
        status,
      ];
}
