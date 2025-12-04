#!/bin/bash

# Dashboard Page
cat > dashboard/dashboard_page.dart << 'EOF'
import 'package:flutter/material.dart';
import '../../../app/routes.dart';

class DashboardPage extends StatelessWidget {
  const DashboardPage({super.key});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Dashboard'),
        actions: [
          IconButton(
            icon: const Icon(Icons.notifications),
            onPressed: () {
              Navigator.of(context).pushNamed(AppRoutes.notifications);
            },
          ),
        ],
      ),
      body: GridView.count(
        crossAxisCount: 2,
        padding: const EdgeInsets.all(16),
        mainAxisSpacing: 16,
        crossAxisSpacing: 16,
        children: [
          _buildMenuCard(context, 'Absensi', Icons.fingerprint, AppRoutes.clockInOut),
          _buildMenuCard(context, 'Riwayat', Icons.history, AppRoutes.attendanceHistory),
          _buildMenuCard(context, 'Cuti', Icons.event_busy, AppRoutes.leaveList),
          _buildMenuCard(context, 'Lembur', Icons.access_time, AppRoutes.overtimeList),
          _buildMenuCard(context, 'Jadwal', Icons.calendar_today, AppRoutes.schedule),
          _buildMenuCard(context, 'Slip Gaji', Icons.payment, AppRoutes.payslipList),
          _buildMenuCard(context, 'Profil', Icons.person, AppRoutes.profile),
        ],
      ),
    );
  }

  Widget _buildMenuCard(BuildContext context, String title, IconData icon, String route) {
    return Card(
      child: InkWell(
        onTap: () => Navigator.of(context).pushNamed(route),
        child: Column(
          mainAxisAlignment: MainAxisAlignment.center,
          children: [
            Icon(icon, size: 48, color: Theme.of(context).primaryColor),
            const SizedBox(height: 8),
            Text(title, style: const TextStyle(fontSize: 16, fontWeight: FontWeight.bold)),
          ],
        ),
      ),
    );
  }
}
EOF

# Create attendance pages
cat > attendance/clock_in_out_page.dart << 'EOF'
import 'package:flutter/material.dart';

class ClockInOutPage extends StatelessWidget {
  const ClockInOutPage({super.key});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(title: const Text('Clock In/Out')),
      body: const Center(child: Text('Clock In/Out Feature - Coming Soon')),
    );
  }
}
EOF

cat > attendance/attendance_history_page.dart << 'EOF'
import 'package:flutter/material.dart';

class AttendanceHistoryPage extends StatelessWidget {
  const AttendanceHistoryPage({super.key});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(title: const Text('Riwayat Absensi')),
      body: const Center(child: Text('Attendance History - Coming Soon')),
    );
  }
}
EOF

# Create leave pages
cat > leave/leave_list_page.dart << 'EOF'
import 'package:flutter/material.dart';
import '../../../app/routes.dart';

class LeaveListPage extends StatelessWidget {
  const LeaveListPage({super.key});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(title: const Text('Pengajuan Cuti')),
      body: const Center(child: Text('Leave List - Coming Soon')),
      floatingActionButton: FloatingActionButton(
        onPressed: () => Navigator.of(context).pushNamed(AppRoutes.leaveForm),
        child: const Icon(Icons.add),
      ),
    );
  }
}
EOF

cat > leave/leave_form_page.dart << 'EOF'
import 'package:flutter/material.dart';

class LeaveFormPage extends StatelessWidget {
  const LeaveFormPage({super.key});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(title: const Text('Ajukan Cuti')),
      body: const Center(child: Text('Leave Form - Coming Soon')),
    );
  }
}
EOF

# Create overtime pages
cat > overtime/overtime_list_page.dart << 'EOF'
import 'package:flutter/material.dart';
import '../../../app/routes.dart';

class OvertimeListPage extends StatelessWidget {
  const OvertimeListPage({super.key});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(title: const Text('Pengajuan Lembur')),
      body: const Center(child: Text('Overtime List - Coming Soon')),
      floatingActionButton: FloatingActionButton(
        onPressed: () => Navigator.of(context).pushNamed(AppRoutes.overtimeForm),
        child: const Icon(Icons.add),
      ),
    );
  }
}
EOF

cat > overtime/overtime_form_page.dart << 'EOF'
import 'package:flutter/material.dart';

class OvertimeFormPage extends StatelessWidget {
  const OvertimeFormPage({super.key});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(title: const Text('Ajukan Lembur')),
      body: const Center(child: Text('Overtime Form - Coming Soon')),
    );
  }
}
EOF

# Create schedule page
cat > schedule/schedule_page.dart << 'EOF'
import 'package:flutter/material.dart';

class SchedulePage extends StatelessWidget {
  const SchedulePage({super.key});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(title: const Text('Jadwal Kerja')),
      body: const Center(child: Text('Schedule - Coming Soon')),
    );
  }
}
EOF

# Create payroll pages
cat > payroll/payslip_list_page.dart << 'EOF'
import 'package:flutter/material.dart';

class PayslipListPage extends StatelessWidget {
  const PayslipListPage({super.key});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(title: const Text('Slip Gaji')),
      body: const Center(child: Text('Payslip List - Coming Soon')),
    );
  }
}
EOF

# Create profile pages
cat > profile/profile_page.dart << 'EOF'
import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import '../../../app/routes.dart';
import '../../blocs/auth/auth_bloc.dart';

class ProfilePage extends StatelessWidget {
  const ProfilePage({super.key});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(title: const Text('Profil')),
      body: ListView(
        children: [
          ListTile(
            leading: const Icon(Icons.edit),
            title: const Text('Edit Profil'),
            onTap: () => Navigator.of(context).pushNamed(AppRoutes.editProfile),
          ),
          ListTile(
            leading: const Icon(Icons.lock),
            title: const Text('Ganti Password'),
            onTap: () => Navigator.of(context).pushNamed(AppRoutes.changePassword),
          ),
          const Divider(),
          ListTile(
            leading: const Icon(Icons.logout, color: Colors.red),
            title: const Text('Keluar', style: TextStyle(color: Colors.red)),
            onTap: () {
              context.read<AuthBloc>().add(LogoutEvent());
              Navigator.of(context).pushNamedAndRemoveUntil(
                AppRoutes.login,
                (route) => false,
              );
            },
          ),
        ],
      ),
    );
  }
}
EOF

cat > profile/edit_profile_page.dart << 'EOF'
import 'package:flutter/material.dart';

class EditProfilePage extends StatelessWidget {
  const EditProfilePage({super.key});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(title: const Text('Edit Profil')),
      body: const Center(child: Text('Edit Profile - Coming Soon')),
    );
  }
}
EOF

cat > profile/change_password_page.dart << 'EOF'
import 'package:flutter/material.dart';

class ChangePasswordPage extends StatelessWidget {
  const ChangePasswordPage({super.key});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(title: const Text('Ganti Password')),
      body: const Center(child: Text('Change Password - Coming Soon')),
    );
  }
}
EOF

# Create notifications page
cat > notifications/notifications_page.dart << 'EOF'
import 'package:flutter/material.dart';

class NotificationsPage extends StatelessWidget {
  const NotificationsPage({super.key});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(title: const Text('Notifikasi')),
      body: const Center(child: Text('Notifications - Coming Soon')),
    );
  }
}
EOF

echo "All pages created"
