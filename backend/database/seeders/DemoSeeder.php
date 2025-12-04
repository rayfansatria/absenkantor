<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Institution;
use App\Models\Branch;
use App\Models\Department;
use App\Models\Position;
use App\Models\User;
use App\Models\Employee;
use App\Models\LeaveType;
use App\Models\WorkShift;
use App\Models\AttendanceLocation;
use App\Models\EmployeeAttendance;
use App\Models\DailySchedule;
use App\Models\EmployeeLeaveBalance;
use App\Models\Announcement;
use App\Models\Holiday;
use Carbon\Carbon;

class DemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Create Institution
        $institution = Institution::create([
            'code' => 'INST001',
            'name' => 'PT Absensi Kantor Indonesia',
            'address' => 'Jl. Sudirman No. 123, Jakarta Pusat',
            'phone' => '021-12345678',
            'email' => 'info@absenkantor.com',
            'timezone' => 'Asia/Jakarta',
            'latitude' => -6.208763,
            'longitude' => 106.845599,
            'geofence_radius' => 100,
            'is_active' => true,
        ]);

        // 2. Create Branch
        $branch = Branch::create([
            'institution_id' => $institution->id,
            'code' => 'BRH001',
            'name' => 'Kantor Pusat Jakarta',
            'address' => 'Jl. Sudirman No. 123, Jakarta Pusat',
            'phone' => '021-12345678',
            'latitude' => -6.208763,
            'longitude' => 106.845599,
            'is_active' => true,
        ]);

        // 3. Create Departments
        $departments = [
            ['code' => 'IT', 'name' => 'IT & Development'],
            ['code' => 'HR', 'name' => 'Human Resources'],
            ['code' => 'FIN', 'name' => 'Finance'],
        ];

        $departmentModels = [];
        foreach ($departments as $dept) {
            $departmentModels[$dept['code']] = Department::create([
                'institution_id' => $institution->id,
                'code' => $dept['code'],
                'name' => $dept['name'],
                'is_active' => true,
            ]);
        }

        // 4. Create Positions
        $positions = [
            ['code' => 'MGR', 'name' => 'Manager'],
            ['code' => 'SPV', 'name' => 'Supervisor'],
            ['code' => 'STF', 'name' => 'Staff'],
        ];

        $positionModels = [];
        foreach ($positions as $pos) {
            $positionModels[$pos['code']] = Position::create([
                'institution_id' => $institution->id,
                'code' => $pos['code'],
                'name' => $pos['name'],
                'is_active' => true,
            ]);
        }

        // 5. Create Work Shift
        $regularShift = WorkShift::create([
            'institution_id' => $institution->id,
            'code' => 'REGULAR',
            'name' => 'Regular Office Hours',
            'clock_in_time' => '08:00:00',
            'clock_out_time' => '17:00:00',
            'late_tolerance_minutes' => 15,
            'is_active' => true,
        ]);

        // 6. Create Attendance Locations
        $locations = [
            [
                'name' => 'Kantor Pusat - Main Building',
                'latitude' => -6.208763,
                'longitude' => 106.845599,
                'radius' => 100,
            ],
            [
                'name' => 'Kantor Pusat - Parking Area',
                'latitude' => -6.208863,
                'longitude' => 106.845699,
                'radius' => 50,
            ],
            [
                'name' => 'Work From Home',
                'latitude' => 0,
                'longitude' => 0,
                'radius' => 999999,
            ],
        ];

        foreach ($locations as $loc) {
            AttendanceLocation::create([
                'institution_id' => $institution->id,
                'name' => $loc['name'],
                'address' => $institution->address,
                'latitude' => $loc['latitude'],
                'longitude' => $loc['longitude'],
                'radius' => $loc['radius'],
                'is_active' => true,
            ]);
        }

        // 7. Create Leave Types
        $leaveTypes = [
            ['code' => 'ANNUAL', 'name' => 'Cuti Tahunan', 'quota' => 12],
            ['code' => 'SICK', 'name' => 'Cuti Sakit', 'quota' => 12],
            ['code' => 'UNPAID', 'name' => 'Cuti Tanpa Gaji', 'quota' => 0],
        ];

        $leaveTypeModels = [];
        foreach ($leaveTypes as $lt) {
            $leaveTypeModels[$lt['code']] = LeaveType::create([
                'institution_id' => $institution->id,
                'code' => $lt['code'],
                'name' => $lt['name'],
                'default_quota_days' => $lt['quota'],
                'requires_approval' => true,
                'is_active' => true,
            ]);
        }

        // 8. Create Users and Employees
        $users = [
            [
                'username' => 'admin',
                'email' => 'admin@absenkantor.com',
                'password' => 'password123',
                'user_type' => 'admin',
                'employee' => [
                    'employee_number' => 'EMP001',
                    'full_name' => 'Admin User',
                    'gender' => 'L',
                    'department' => 'IT',
                    'position' => 'MGR',
                ],
            ],
            [
                'username' => 'employee1',
                'email' => 'employee1@absenkantor.com',
                'password' => 'password123',
                'user_type' => 'employee',
                'employee' => [
                    'employee_number' => 'EMP002',
                    'full_name' => 'Budi Santoso',
                    'gender' => 'L',
                    'department' => 'IT',
                    'position' => 'STF',
                ],
            ],
            [
                'username' => 'employee2',
                'email' => 'employee2@absenkantor.com',
                'password' => 'password123',
                'user_type' => 'employee',
                'employee' => [
                    'employee_number' => 'EMP003',
                    'full_name' => 'Siti Nurhaliza',
                    'gender' => 'P',
                    'department' => 'HR',
                    'position' => 'STF',
                ],
            ],
            [
                'username' => 'employee3',
                'email' => 'employee3@absenkantor.com',
                'password' => 'password123',
                'user_type' => 'employee',
                'employee' => [
                    'employee_number' => 'EMP004',
                    'full_name' => 'Ahmad Rifai',
                    'gender' => 'L',
                    'department' => 'FIN',
                    'position' => 'SPV',
                ],
            ],
        ];

        $employees = [];
        foreach ($users as $userData) {
            $user = User::create([
                'institution_id' => $institution->id,
                'username' => $userData['username'],
                'email' => $userData['email'],
                'password' => Hash::make($userData['password']),
                'phone' => '0812345678' . rand(10, 99),
                'user_type' => $userData['user_type'],
                'is_active' => true,
            ]);

            $employee = Employee::create([
                'user_id' => $user->id,
                'institution_id' => $institution->id,
                'branch_id' => $branch->id,
                'employee_number' => $userData['employee']['employee_number'],
                'full_name' => $userData['employee']['full_name'],
                'gender' => $userData['employee']['gender'],
                'birth_date' => Carbon::now()->subYears(rand(25, 40))->format('Y-m-d'),
                'phone' => $user->phone,
                'email' => $user->email,
                'address' => 'Jl. Contoh No. ' . rand(1, 100) . ', Jakarta',
                'department_id' => $departmentModels[$userData['employee']['department']]->id,
                'position_id' => $positionModels[$userData['employee']['position']]->id,
                'join_date' => Carbon::now()->subMonths(rand(1, 24))->format('Y-m-d'),
                'employee_status' => 'permanent',
            ]);

            $employees[] = $employee;

            // Create leave balances for each employee
            foreach ($leaveTypeModels as $leaveType) {
                if ($leaveType->default_quota_days > 0) {
                    EmployeeLeaveBalance::create([
                        'employee_id' => $employee->id,
                        'leave_type_id' => $leaveType->id,
                        'year' => now()->year,
                        'initial_balance' => $leaveType->default_quota_days,
                        'used_balance' => 0,
                        'remaining_balance' => $leaveType->default_quota_days,
                    ]);
                }
            }

            // Create daily schedules for the next 30 days
            for ($i = 0; $i < 30; $i++) {
                $scheduleDate = Carbon::now()->addDays($i);
                
                // Skip weekends
                if ($scheduleDate->isWeekend()) {
                    continue;
                }

                DailySchedule::create([
                    'employee_id' => $employee->id,
                    'work_shift_id' => $regularShift->id,
                    'schedule_date' => $scheduleDate->format('Y-m-d'),
                    'is_dayoff' => false,
                ]);
            }
        }

        // 9. Create sample attendance data for the past 7 days
        foreach ($employees as $employee) {
            for ($i = 1; $i <= 7; $i++) {
                $date = Carbon::now()->subDays($i);
                
                // Skip weekends
                if ($date->isWeekend()) {
                    continue;
                }

                // Randomly create attendance (80% attendance rate)
                if (rand(1, 10) <= 8) {
                    $clockInTime = Carbon::parse($date->format('Y-m-d') . ' 08:00:00')
                        ->addMinutes(rand(-10, 30));
                    
                    $clockOutTime = Carbon::parse($date->format('Y-m-d') . ' 17:00:00')
                        ->addMinutes(rand(-30, 60));

                    $isLate = $clockInTime->format('H:i:s') > '08:15:00';
                    $lateDuration = 0;

                    if ($isLate) {
                        $scheduledTime = Carbon::parse($date->format('Y-m-d') . ' 08:15:00');
                        $lateDuration = $scheduledTime->diffInMinutes($clockInTime);
                    }

                    EmployeeAttendance::create([
                        'employee_id' => $employee->id,
                        'attendance_date' => $date->format('Y-m-d'),
                        'clock_in_time' => $clockInTime->format('H:i:s'),
                        'clock_out_time' => $clockOutTime->format('H:i:s'),
                        'clock_in_latitude' => -6.208763 + (rand(-10, 10) / 10000),
                        'clock_in_longitude' => 106.845599 + (rand(-10, 10) / 10000),
                        'clock_out_latitude' => -6.208763 + (rand(-10, 10) / 10000),
                        'clock_out_longitude' => 106.845599 + (rand(-10, 10) / 10000),
                        'clock_in_address' => 'Kantor Pusat Jakarta',
                        'clock_out_address' => 'Kantor Pusat Jakarta',
                        'work_duration_minutes' => $clockInTime->diffInMinutes($clockOutTime),
                        'attendance_status' => $isLate ? 'late' : 'present',
                        'is_late' => $isLate,
                        'late_duration_minutes' => $lateDuration,
                    ]);
                }
            }
        }

        // 10. Create Holidays
        $holidays = [
            ['name' => 'Tahun Baru 2024', 'date' => '2024-01-01'],
            ['name' => 'Tahun Baru Imlek', 'date' => '2024-02-10'],
            ['name' => 'Hari Raya Nyepi', 'date' => '2024-03-11'],
            ['name' => 'Wafat Isa Almasih', 'date' => '2024-03-29'],
            ['name' => 'Hari Raya Idul Fitri', 'date' => '2024-04-10'],
            ['name' => 'Hari Raya Idul Fitri', 'date' => '2024-04-11'],
            ['name' => 'Hari Buruh Internasional', 'date' => '2024-05-01'],
            ['name' => 'Kenaikan Isa Almasih', 'date' => '2024-05-09'],
            ['name' => 'Hari Raya Waisak', 'date' => '2024-05-23'],
            ['name' => 'Hari Raya Idul Adha', 'date' => '2024-06-17'],
            ['name' => 'Tahun Baru Islam', 'date' => '2024-07-07'],
            ['name' => 'Hari Kemerdekaan RI', 'date' => '2024-08-17'],
            ['name' => 'Maulid Nabi Muhammad SAW', 'date' => '2024-09-16'],
            ['name' => 'Hari Raya Natal', 'date' => '2024-12-25'],
        ];

        foreach ($holidays as $holiday) {
            Holiday::create([
                'institution_id' => $institution->id,
                'name' => $holiday['name'],
                'holiday_date' => $holiday['date'],
                'is_national_holiday' => true,
            ]);
        }

        // 11. Create Announcements
        $announcements = [
            [
                'title' => 'Selamat Datang di Sistem Absensi Kantor',
                'content' => 'Sistem absensi kantor telah aktif. Silakan gunakan aplikasi mobile untuk melakukan clock in/out setiap hari.',
                'type' => 'info',
            ],
            [
                'title' => 'Libur Hari Raya Idul Fitri',
                'content' => 'Kantor akan tutup pada tanggal 10-11 April 2024 dalam rangka merayakan Hari Raya Idul Fitri. Selamat merayakan!',
                'type' => 'holiday',
            ],
            [
                'title' => 'Update Kebijakan Cuti',
                'content' => 'Mulai bulan ini, pengajuan cuti harus dilakukan minimal 3 hari sebelum tanggal cuti yang diinginkan.',
                'type' => 'policy',
            ],
        ];

        foreach ($announcements as $announcement) {
            Announcement::create([
                'institution_id' => $institution->id,
                'title' => $announcement['title'],
                'content' => $announcement['content'],
                'announcement_type' => $announcement['type'],
                'published_at' => now(),
                'is_active' => true,
            ]);
        }

        $this->command->info('Demo data seeded successfully!');
        $this->command->info('');
        $this->command->info('=== Demo Credentials ===');
        $this->command->info('Admin:');
        $this->command->info('  Username: admin');
        $this->command->info('  Password: password123');
        $this->command->info('');
        $this->command->info('Employees:');
        $this->command->info('  Username: employee1, employee2, employee3');
        $this->command->info('  Password: password123');
    }
}
