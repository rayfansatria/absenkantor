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
