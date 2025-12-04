import 'package:equatable/equatable.dart';

class User extends Equatable {
  final int id;
  final String username;
  final String email;
  final String? name;
  final String? phone;
  final String? avatar;
  final int? employeeId;
  final int? institutionId;

  const User({
    required this.id,
    required this.username,
    required this.email,
    this.name,
    this.phone,
    this.avatar,
    this.employeeId,
    this.institutionId,
  });

  @override
  List<Object?> get props => [
        id,
        username,
        email,
        name,
        phone,
        avatar,
        employeeId,
        institutionId,
      ];
}
