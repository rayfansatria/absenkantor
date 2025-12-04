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
