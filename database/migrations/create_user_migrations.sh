#!/bin/bash

# Employees Table
cat > 2024_01_01_000005_create_employees_table.php << 'EOF'
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('institution_id')->constrained()->onDelete('cascade');
            $table->foreignId('branch_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('department_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('position_id')->nullable()->constrained()->onDelete('set null');
            $table->string('employee_number')->unique();
            $table->string('full_name');
            $table->string('email')->unique()->nullable();
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->enum('gender', ['male', 'female'])->nullable();
            $table->date('join_date')->nullable();
            $table->enum('status', ['active', 'inactive', 'resigned'])->default('active');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
EOF

# Update Users Table
cat > 2024_01_01_000006_update_users_table.php << 'EOF'
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('users')) {
            Schema::create('users', function (Blueprint $table) {
                $table->id();
                $table->foreignId('institution_id')->nullable()->constrained()->onDelete('cascade');
                $table->foreignId('employee_id')->nullable()->constrained()->onDelete('cascade');
                $table->string('username')->unique();
                $table->string('email')->unique();
                $table->string('password');
                $table->string('name')->nullable();
                $table->string('phone')->nullable();
                $table->string('avatar')->nullable();
                $table->enum('role', ['admin', 'manager', 'employee'])->default('employee');
                $table->boolean('is_active')->default(true);
                $table->timestamp('email_verified_at')->nullable();
                $table->rememberToken();
                $table->timestamps();
                $table->softDeletes();
            });
        } else {
            Schema::table('users', function (Blueprint $table) {
                if (!Schema::hasColumn('users', 'institution_id')) {
                    $table->foreignId('institution_id')->nullable()->constrained()->onDelete('cascade');
                }
                if (!Schema::hasColumn('users', 'employee_id')) {
                    $table->foreignId('employee_id')->nullable()->constrained()->onDelete('cascade');
                }
                if (!Schema::hasColumn('users', 'username')) {
                    $table->string('username')->unique()->after('id');
                }
                if (!Schema::hasColumn('users', 'phone')) {
                    $table->string('phone')->nullable();
                }
                if (!Schema::hasColumn('users', 'avatar')) {
                    $table->string('avatar')->nullable();
                }
                if (!Schema::hasColumn('users', 'role')) {
                    $table->enum('role', ['admin', 'manager', 'employee'])->default('employee');
                }
                if (!Schema::hasColumn('users', 'is_active')) {
                    $table->boolean('is_active')->default(true);
                }
            });
        }
    }

    public function down(): void
    {
        // Don't drop users table as it's core to Laravel
    }
};
EOF

echo "User and employee migrations created"
