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
