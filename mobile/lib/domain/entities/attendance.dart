import 'package:equatable/equatable.dart';

class Attendance extends Equatable {
  final int id;
  final int employeeId;
  final DateTime date;
  final DateTime? clockIn;
  final DateTime? clockOut;
  final String? clockInLocation;
  final String? clockOutLocation;
  final double? clockInLatitude;
  final double? clockInLongitude;
  final double? clockOutLatitude;
  final double? clockOutLongitude;
  final String? clockInPhoto;
  final String? clockOutPhoto;
  final String? clockInNotes;
  final String? clockOutNotes;
  final String status;
  final int? workShiftId;
  final String? workShiftName;
  final int? workHours;
  final bool isLate;
  final bool isEarlyLeave;

  const Attendance({
    required this.id,
    required this.employeeId,
    required this.date,
    this.clockIn,
    this.clockOut,
    this.clockInLocation,
    this.clockOutLocation,
    this.clockInLatitude,
    this.clockInLongitude,
    this.clockOutLatitude,
    this.clockOutLongitude,
    this.clockInPhoto,
    this.clockOutPhoto,
    this.clockInNotes,
    this.clockOutNotes,
    required this.status,
    this.workShiftId,
    this.workShiftName,
    this.workHours,
    this.isLate = false,
    this.isEarlyLeave = false,
  });

  @override
  List<Object?> get props => [
        id,
        employeeId,
        date,
        clockIn,
        clockOut,
        clockInLocation,
        clockOutLocation,
        clockInLatitude,
        clockInLongitude,
        clockOutLatitude,
        clockOutLongitude,
        clockInPhoto,
        clockOutPhoto,
        clockInNotes,
        clockOutNotes,
        status,
        workShiftId,
        workShiftName,
        workHours,
        isLate,
        isEarlyLeave,
      ];
}
