# Database Schema Documentation

Database: `db_absensi_general`
Type: MySQL 5.7+
Character Set: utf8mb4
Collation: utf8mb4_unicode_ci

## Architecture

This database uses a **multi-tenant architecture** based on institutions. Each institution (company/organization) has its own data separation while sharing the same database.

## Core Tables

### institutions
Stores organization/company information.

| Column | Type | Description |
|--------|------|-------------|
| id | BIGINT | Primary key |
| name | VARCHAR(255) | Institution name |
| code | VARCHAR(255) | Unique institution code |
| address | TEXT | Address |
| phone | VARCHAR(255) | Phone number |
| email | VARCHAR(255) | Email address |
| logo | VARCHAR(255) | Logo file path |
| is_active | BOOLEAN | Active status |
| created_at | TIMESTAMP | Creation timestamp |
| updated_at | TIMESTAMP | Update timestamp |
| deleted_at | TIMESTAMP | Soft delete timestamp |

### branches
Branch offices of institutions.

| Column | Type | Description |
|--------|------|-------------|
| id | BIGINT | Primary key |
| institution_id | BIGINT | FK to institutions |
| name | VARCHAR(255) | Branch name |
| code | VARCHAR(255) | Unique branch code |
| address | TEXT | Address |
| phone | VARCHAR(255) | Phone number |
| is_active | BOOLEAN | Active status |

### departments
Departments within institutions.

| Column | Type | Description |
|--------|------|-------------|
| id | BIGINT | Primary key |
| institution_id | BIGINT | FK to institutions |
| name | VARCHAR(255) | Department name |
| code | VARCHAR(255) | Unique department code |
| description | TEXT | Description |
| is_active | BOOLEAN | Active status |

### positions
Job positions within institutions.

| Column | Type | Description |
|--------|------|-------------|
| id | BIGINT | Primary key |
| institution_id | BIGINT | FK to institutions |
| name | VARCHAR(255) | Position name |
| code | VARCHAR(255) | Unique position code |
| description | TEXT | Description |
| level | INTEGER | Position level |
| is_active | BOOLEAN | Active status |

## User Management Tables

### users
User accounts with authentication.

| Column | Type | Description |
|--------|------|-------------|
| id | BIGINT | Primary key |
| institution_id | BIGINT | FK to institutions |
| employee_id | BIGINT | FK to employees |
| username | VARCHAR(255) | Unique username |
| email | VARCHAR(255) | Unique email |
| password | VARCHAR(255) | Hashed password |
| name | VARCHAR(255) | Display name |
| phone | VARCHAR(255) | Phone number |
| avatar | VARCHAR(255) | Avatar file path |
| role | ENUM | admin, manager, employee |
| is_active | BOOLEAN | Active status |
| email_verified_at | TIMESTAMP | Email verification |
| remember_token | VARCHAR(100) | Remember token |

### employees
Employee information.

| Column | Type | Description |
|--------|------|-------------|
| id | BIGINT | Primary key |
| institution_id | BIGINT | FK to institutions |
| branch_id | BIGINT | FK to branches |
| department_id | BIGINT | FK to departments |
| position_id | BIGINT | FK to positions |
| employee_number | VARCHAR(255) | Unique employee number |
| full_name | VARCHAR(255) | Full name |
| email | VARCHAR(255) | Email address |
| phone | VARCHAR(255) | Phone number |
| address | TEXT | Home address |
| date_of_birth | DATE | Date of birth |
| gender | ENUM | male, female |
| join_date | DATE | Join date |
| status | ENUM | active, inactive, resigned |

## Attendance Tables

### work_shifts
Work shift definitions.

| Column | Type | Description |
|--------|------|-------------|
| id | BIGINT | Primary key |
| institution_id | BIGINT | FK to institutions |
| name | VARCHAR(255) | Shift name |
| start_time | TIME | Start time |
| end_time | TIME | End time |
| work_hours | INTEGER | Work hours |
| is_active | BOOLEAN | Active status |

### attendance_locations
Valid GPS locations for attendance.

| Column | Type | Description |
|--------|------|-------------|
| id | BIGINT | Primary key |
| institution_id | BIGINT | FK to institutions |
| branch_id | BIGINT | FK to branches |
| name | VARCHAR(255) | Location name |
| address | TEXT | Address |
| latitude | DECIMAL(10,8) | GPS latitude |
| longitude | DECIMAL(11,8) | GPS longitude |
| radius | INTEGER | Geofence radius (meters) |
| is_active | BOOLEAN | Active status |

### employee_attendances
Daily attendance records.

| Column | Type | Description |
|--------|------|-------------|
| id | BIGINT | Primary key |
| employee_id | BIGINT | FK to employees |
| work_shift_id | BIGINT | FK to work_shifts |
| date | DATE | Attendance date |
| clock_in | TIMESTAMP | Clock in time |
| clock_out | TIMESTAMP | Clock out time |
| clock_in_latitude | DECIMAL(10,8) | Clock in GPS latitude |
| clock_in_longitude | DECIMAL(11,8) | Clock in GPS longitude |
| clock_out_latitude | DECIMAL(10,8) | Clock out GPS latitude |
| clock_out_longitude | DECIMAL(11,8) | Clock out GPS longitude |
| clock_in_photo | VARCHAR(255) | Clock in photo path |
| clock_out_photo | VARCHAR(255) | Clock out photo path |
| clock_in_notes | TEXT | Clock in notes |
| clock_out_notes | TEXT | Clock out notes |
| clock_in_location | VARCHAR(255) | Clock in location name |
| clock_out_location | VARCHAR(255) | Clock out location name |
| status | ENUM | present, absent, late, on_leave, overtime |
| is_late | BOOLEAN | Late indicator |
| is_early_leave | BOOLEAN | Early leave indicator |
| work_hours | INTEGER | Total work hours |

**Unique Key:** (employee_id, date)

### attendance_logs
Detailed logs for each attendance action.

| Column | Type | Description |
|--------|------|-------------|
| id | BIGINT | Primary key |
| employee_attendance_id | BIGINT | FK to employee_attendances |
| type | ENUM | clock_in, clock_out |
| timestamp | TIMESTAMP | Action timestamp |
| latitude | DECIMAL(10,8) | GPS latitude |
| longitude | DECIMAL(11,8) | GPS longitude |
| photo | VARCHAR(255) | Photo file path |
| notes | TEXT | Notes |

### attendance_summaries
Monthly attendance summaries.

| Column | Type | Description |
|--------|------|-------------|
| id | BIGINT | Primary key |
| employee_id | BIGINT | FK to employees |
| month | INTEGER | Month (1-12) |
| year | INTEGER | Year |
| total_days | INTEGER | Total work days |
| present_days | INTEGER | Present days |
| late_days | INTEGER | Late days |
| absent_days | INTEGER | Absent days |
| leave_days | INTEGER | Leave days |
| overtime_hours | INTEGER | Total overtime hours |
| total_work_hours | INTEGER | Total work hours |

**Unique Key:** (employee_id, month, year)

### daily_schedules
Employee daily work schedules.

| Column | Type | Description |
|--------|------|-------------|
| id | BIGINT | Primary key |
| employee_id | BIGINT | FK to employees |
| work_shift_id | BIGINT | FK to work_shifts |
| date | DATE | Schedule date |
| notes | TEXT | Notes |

**Unique Key:** (employee_id, date)

## Leave Management Tables

### leave_types
Types of leave available.

| Column | Type | Description |
|--------|------|-------------|
| id | BIGINT | Primary key |
| institution_id | BIGINT | FK to institutions |
| name | VARCHAR(255) | Leave type name |
| code | VARCHAR(255) | Unique code |
| description | TEXT | Description |
| max_days_per_year | INTEGER | Maximum days per year |
| requires_approval | BOOLEAN | Requires approval |
| is_paid | BOOLEAN | Paid leave |
| is_active | BOOLEAN | Active status |

### employee_leave_balances
Employee leave balances per year.

| Column | Type | Description |
|--------|------|-------------|
| id | BIGINT | Primary key |
| employee_id | BIGINT | FK to employees |
| leave_type_id | BIGINT | FK to leave_types |
| year | INTEGER | Year |
| total_days | INTEGER | Total allocated days |
| used_days | INTEGER | Used days |
| remaining_days | INTEGER | Remaining days |

**Unique Key:** (employee_id, leave_type_id, year)

### leave_requests
Employee leave requests.

| Column | Type | Description |
|--------|------|-------------|
| id | BIGINT | Primary key |
| employee_id | BIGINT | FK to employees |
| leave_type_id | BIGINT | FK to leave_types |
| start_date | DATE | Leave start date |
| end_date | DATE | Leave end date |
| total_days | INTEGER | Total days |
| reason | TEXT | Leave reason |
| attachment | VARCHAR(255) | Supporting document |
| delegate_to_employee_id | BIGINT | FK to employees (delegate) |
| status | ENUM | pending, approved, rejected, cancelled |
| rejection_reason | TEXT | Rejection reason |

### leave_approvals
Leave approval workflow.

| Column | Type | Description |
|--------|------|-------------|
| id | BIGINT | Primary key |
| leave_request_id | BIGINT | FK to leave_requests |
| approver_id | BIGINT | FK to users |
| status | ENUM | approved, rejected |
| notes | TEXT | Approval notes |
| approved_at | TIMESTAMP | Approval timestamp |

## Overtime Tables

### overtime_requests
Employee overtime requests.

| Column | Type | Description |
|--------|------|-------------|
| id | BIGINT | Primary key |
| employee_id | BIGINT | FK to employees |
| date | DATE | Overtime date |
| start_time | TIME | Start time |
| end_time | TIME | End time |
| total_hours | INTEGER | Total hours |
| description | TEXT | Description |
| status | ENUM | pending, approved, rejected |
| rejection_reason | TEXT | Rejection reason |
| approved_by | BIGINT | FK to users |
| approved_at | TIMESTAMP | Approval timestamp |

## Payroll Tables

### payroll_periods
Payroll period definitions.

| Column | Type | Description |
|--------|------|-------------|
| id | BIGINT | Primary key |
| institution_id | BIGINT | FK to institutions |
| name | VARCHAR(255) | Period name |
| start_date | DATE | Start date |
| end_date | DATE | End date |
| month | INTEGER | Month |
| year | INTEGER | Year |
| status | ENUM | draft, processed, paid |

### payslips
Employee payslips.

| Column | Type | Description |
|--------|------|-------------|
| id | BIGINT | Primary key |
| employee_id | BIGINT | FK to employees |
| payroll_period_id | BIGINT | FK to payroll_periods |
| basic_salary | DECIMAL(15,2) | Basic salary |
| total_allowances | DECIMAL(15,2) | Total allowances |
| total_deductions | DECIMAL(15,2) | Total deductions |
| net_salary | DECIMAL(15,2) | Net salary |
| file_path | VARCHAR(255) | PDF file path |
| generated_at | TIMESTAMP | Generation timestamp |

### payslip_details
Payslip component details.

| Column | Type | Description |
|--------|------|-------------|
| id | BIGINT | Primary key |
| payslip_id | BIGINT | FK to payslips |
| type | ENUM | allowance, deduction |
| name | VARCHAR(255) | Component name |
| amount | DECIMAL(15,2) | Amount |
| description | TEXT | Description |

## Other Tables

### notifications
User notifications.

| Column | Type | Description |
|--------|------|-------------|
| id | BIGINT | Primary key |
| user_id | BIGINT | FK to users |
| title | VARCHAR(255) | Notification title |
| message | TEXT | Notification message |
| type | ENUM | attendance, leave, overtime, announcement, payroll, general |
| data | JSON | Additional data |
| is_read | BOOLEAN | Read status |
| read_at | TIMESTAMP | Read timestamp |

### announcements
Company announcements.

| Column | Type | Description |
|--------|------|-------------|
| id | BIGINT | Primary key |
| institution_id | BIGINT | FK to institutions |
| created_by | BIGINT | FK to users |
| title | VARCHAR(255) | Announcement title |
| content | TEXT | Announcement content |
| priority | ENUM | low, normal, high |
| published_at | TIMESTAMP | Publication timestamp |
| expires_at | TIMESTAMP | Expiration timestamp |
| is_active | BOOLEAN | Active status |

### holidays
Holiday calendar.

| Column | Type | Description |
|--------|------|-------------|
| id | BIGINT | Primary key |
| institution_id | BIGINT | FK to institutions (nullable for national holidays) |
| name | VARCHAR(255) | Holiday name |
| date | DATE | Holiday date |
| description | TEXT | Description |
| type | ENUM | national, religious, company |
| is_active | BOOLEAN | Active status |

### user_sessions
User session management.

| Column | Type | Description |
|--------|------|-------------|
| id | BIGINT | Primary key |
| user_id | BIGINT | FK to users |
| token | VARCHAR(255) | Session token |
| device_name | VARCHAR(255) | Device name |
| device_type | VARCHAR(255) | Device type |
| ip_address | VARCHAR(255) | IP address |
| user_agent | TEXT | User agent string |
| last_activity_at | TIMESTAMP | Last activity timestamp |
| expires_at | TIMESTAMP | Expiration timestamp |

## Indexes

### Recommended Indexes

```sql
-- Users
CREATE INDEX idx_users_institution ON users(institution_id);
CREATE INDEX idx_users_employee ON users(employee_id);
CREATE INDEX idx_users_email ON users(email);

-- Employees
CREATE INDEX idx_employees_institution ON employees(institution_id);
CREATE INDEX idx_employees_number ON employees(employee_number);

-- Attendances
CREATE INDEX idx_attendances_employee_date ON employee_attendances(employee_id, date);
CREATE INDEX idx_attendances_date ON employee_attendances(date);
CREATE INDEX idx_attendances_status ON employee_attendances(status);

-- Leave Requests
CREATE INDEX idx_leave_requests_employee ON leave_requests(employee_id);
CREATE INDEX idx_leave_requests_status ON leave_requests(status);
CREATE INDEX idx_leave_requests_dates ON leave_requests(start_date, end_date);

-- Notifications
CREATE INDEX idx_notifications_user ON notifications(user_id);
CREATE INDEX idx_notifications_read ON notifications(is_read);
```

## Relationships

### One-to-Many Relationships
- Institution → Branches
- Institution → Departments
- Institution → Positions
- Institution → Employees
- Employee → Attendances
- Employee → Leave Requests
- Employee → Overtime Requests
- Employee → Payslips
- Payslip → Payslip Details

### Many-to-One Relationships
- User → Institution
- User → Employee
- Employee → Branch
- Employee → Department
- Employee → Position
- Attendance → Employee
- Attendance → Work Shift
- Leave Request → Employee
- Leave Request → Leave Type

## Data Integrity

### Foreign Key Constraints
All foreign keys have appropriate ON DELETE actions:
- CASCADE: Child records deleted when parent is deleted
- SET NULL: Foreign key set to NULL when parent is deleted
- RESTRICT: Prevents deletion if child records exist

### Soft Deletes
Most tables implement soft deletes (deleted_at column) to maintain data integrity and audit trails.

### Unique Constraints
- users: username, email
- employees: employee_number
- employee_attendances: (employee_id, date)
- daily_schedules: (employee_id, date)
- employee_leave_balances: (employee_id, leave_type_id, year)

## Security Considerations

1. **Password Storage**: Passwords are hashed using bcrypt
2. **JWT Tokens**: Stored securely, not in database
3. **Soft Deletes**: Sensitive data retained for audit
4. **Multi-tenancy**: Institution-level data separation
5. **Timestamps**: All tables track created_at and updated_at

## Backup Strategy

Recommended backup approach:
- Daily full database backups
- Transaction log backups every hour
- Retention: 30 days minimum
- Test restore procedures regularly

## Maintenance

### Regular Tasks
- Optimize tables monthly
- Update statistics weekly
- Check and repair tables monthly
- Archive old data annually
- Monitor slow queries

### Performance Tips
- Add indexes for frequently queried columns
- Partition large tables by date
- Archive old attendance records
- Regular ANALYZE TABLE
- Monitor query performance
