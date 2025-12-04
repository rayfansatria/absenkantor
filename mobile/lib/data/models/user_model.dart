import 'dart:convert';
import '../../domain/entities/user.dart';

class UserModel {
  final int id;
  final String username;
  final String email;
  final String? name;
  final String? phone;
  final String? avatar;
  final int? employeeId;
  final int? institutionId;

  UserModel({
    required this.id,
    required this.username,
    required this.email,
    this.name,
    this.phone,
    this.avatar,
    this.employeeId,
    this.institutionId,
  });

  factory UserModel.fromJson(Map<String, dynamic> json) {
    return UserModel(
      id: json['id'],
      username: json['username'],
      email: json['email'],
      name: json['name'],
      phone: json['phone'],
      avatar: json['avatar'],
      employeeId: json['employee_id'],
      institutionId: json['institution_id'],
    );
  }

  factory UserModel.fromRawJson(String str) =>
      UserModel.fromJson(json.decode(str));

  Map<String, dynamic> toJson() {
    return {
      'id': id,
      'username': username,
      'email': email,
      'name': name,
      'phone': phone,
      'avatar': avatar,
      'employee_id': employeeId,
      'institution_id': institutionId,
    };
  }

  String toRawJson() => json.encode(toJson());

  User toEntity() {
    return User(
      id: id,
      username: username,
      email: email,
      name: name,
      phone: phone,
      avatar: avatar,
      employeeId: employeeId,
      institutionId: institutionId,
    );
  }
}
