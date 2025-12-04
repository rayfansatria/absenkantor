# Backend Testing Checklist

This document provides a checklist for testing the AbsenKantor Backend API after installation.

## Prerequisites

Before testing, ensure you have:
- [ ] Installed dependencies with `composer install`
- [ ] Configured `.env` file with database credentials
- [ ] Generated app key with `php artisan key:generate`
- [ ] Generated JWT secret with `php artisan jwt:secret`
- [ ] Run migrations with `php artisan migrate`
- [ ] Started server with `php artisan serve`

## API Endpoint Testing

### Authentication Endpoints

#### Login
- [ ] Test successful login with username
- [ ] Test successful login with email
- [ ] Test login with invalid credentials
- [ ] Test login with inactive user account
- [ ] Verify JWT token is returned
- [ ] Verify user session is created

**Example Request:**
```bash
curl -X POST http://localhost:8000/api/auth/login \
  -H "Content-Type: application/json" \
  -d '{"username": "admin", "password": "password"}'
```

#### Logout
- [ ] Test logout with valid token
- [ ] Test logout with invalid token
- [ ] Verify session is deleted
- [ ] Verify token is invalidated

#### Refresh Token
- [ ] Test token refresh with valid token
- [ ] Test token refresh with expired token
- [ ] Verify new token is returned

### Profile Endpoints

#### Get Profile
- [ ] Test getting profile with valid token
- [ ] Test with employee data present
- [ ] Test with no employee data
- [ ] Verify all relationships are loaded

#### Update Profile
- [ ] Test updating email
- [ ] Test updating phone
- [ ] Test updating address
- [ ] Test with invalid data
- [ ] Verify email uniqueness validation

#### Change Password
- [ ] Test with correct current password
- [ ] Test with incorrect current password
- [ ] Test with weak new password
- [ ] Verify password is hashed

#### Upload Avatar
- [ ] Test uploading valid image (JPEG, PNG)
- [ ] Test with oversized image (>2MB)
- [ ] Test with invalid file type
- [ ] Verify old avatar is deleted
- [ ] Verify avatar URL is returned

### Attendance Endpoints

#### Clock In
- [ ] Test with valid GPS location (within radius)
- [ ] Test with invalid GPS location (outside radius)
- [ ] Test with valid photo
- [ ] Test with invalid photo format
- [ ] Test with oversized photo
- [ ] Test duplicate clock in on same day
- [ ] Verify attendance record is created

#### Clock Out
- [ ] Test with valid GPS location
- [ ] Test without prior clock in
- [ ] Test with valid photo
- [ ] Test duplicate clock out
- [ ] Verify work duration is calculated
- [ ] Verify attendance record is updated

#### Today's Attendance
- [ ] Test before clock in
- [ ] Test after clock in but before clock out
- [ ] Test after clock out
- [ ] Verify status flags are correct

#### Attendance History
- [ ] Test without filters
- [ ] Test with month/year filter
- [ ] Test pagination
- [ ] Verify data is ordered by date desc

#### Monthly Summary
- [ ] Test with default (current) month
- [ ] Test with specific month/year
- [ ] Verify calculations are correct
- [ ] Verify all status counts are accurate

#### Valid Locations
- [ ] Test getting locations
- [ ] Verify only active locations are returned
- [ ] Verify institution filtering works

### Leave Endpoints

#### List Leaves
- [ ] Test getting all leave requests
- [ ] Test pagination
- [ ] Verify leave type relationship loaded
- [ ] Verify approvals relationship loaded

#### Create Leave
- [ ] Test with valid data
- [ ] Test with insufficient balance
- [ ] Test with invalid dates
- [ ] Test with invalid leave type
- [ ] Test with attachment upload
- [ ] Verify total days calculation

#### Get Leave Detail
- [ ] Test with valid leave ID
- [ ] Test with invalid leave ID
- [ ] Test accessing other employee's leave
- [ ] Verify all relationships loaded

#### Cancel Leave
- [ ] Test canceling pending leave
- [ ] Test canceling approved leave (should fail)
- [ ] Test canceling other employee's leave
- [ ] Verify soft delete works

#### Get Leave Types
- [ ] Test getting types
- [ ] Verify only active types returned
- [ ] Verify institution filtering works

#### Get Leave Balance
- [ ] Test getting balances
- [ ] Verify current year filtering
- [ ] Verify leave type relationship loaded

### Overtime Endpoints

#### List Overtimes
- [ ] Test getting all overtime requests
- [ ] Test pagination
- [ ] Verify approver relationship loaded

#### Create Overtime
- [ ] Test with valid data
- [ ] Test with invalid dates
- [ ] Test with invalid reason length
- [ ] Verify duration calculation

#### Get Overtime Detail
- [ ] Test with valid overtime ID
- [ ] Test with invalid overtime ID
- [ ] Test accessing other employee's overtime

### Schedule Endpoints

#### Get Schedules
- [ ] Test getting schedules
- [ ] Test with month/year filter
- [ ] Test pagination
- [ ] Verify shift relationship loaded

#### Get Shifts
- [ ] Test getting shifts
- [ ] Verify only active shifts returned
- [ ] Verify institution filtering

#### Get Holidays
- [ ] Test getting holidays
- [ ] Test with year filter
- [ ] Verify institution filtering

### Payroll Endpoints

#### List Payslips
- [ ] Test getting payslips
- [ ] Test pagination
- [ ] Verify payroll period relationship

#### Get Payslip Detail
- [ ] Test with valid payslip ID
- [ ] Test with invalid payslip ID
- [ ] Test accessing other employee's payslip
- [ ] Verify details relationship loaded

#### Download Payslip
- [ ] Test PDF download (when implemented)

### Notification Endpoints

#### List Notifications
- [ ] Test getting notifications
- [ ] Test pagination
- [ ] Verify ordering by date desc

#### Mark as Read
- [ ] Test marking single notification
- [ ] Test with invalid notification ID
- [ ] Verify read_at timestamp set

#### Mark All as Read
- [ ] Test marking all notifications
- [ ] Verify all unread notifications updated

### Announcement Endpoints

#### List Announcements
- [ ] Test getting announcements
- [ ] Test pagination
- [ ] Verify only active announcements
- [ ] Verify published date filtering
- [ ] Verify expiry date filtering

## Security Testing

### Authentication
- [ ] Test accessing protected routes without token
- [ ] Test with expired token
- [ ] Test with invalid token format
- [ ] Test with token from different user
- [ ] Verify middleware is applied to all protected routes

### Authorization
- [ ] Test accessing other employee's data
- [ ] Test cross-institution data access
- [ ] Verify employee-level data isolation

### Input Validation
- [ ] Test SQL injection attempts
- [ ] Test XSS attempts in text fields
- [ ] Test file upload exploits
- [ ] Test excessive data in requests
- [ ] Verify all inputs are validated

## Performance Testing

- [ ] Test response times for list endpoints
- [ ] Test with large datasets (pagination)
- [ ] Test concurrent requests
- [ ] Test file upload performance
- [ ] Monitor database query counts

## Error Handling

- [ ] Test invalid JSON in request body
- [ ] Test missing required fields
- [ ] Test invalid data types
- [ ] Test database connection errors
- [ ] Verify error responses are consistent

## Integration Testing

### Database
- [ ] Verify all migrations run successfully
- [ ] Test foreign key constraints
- [ ] Test cascade deletes
- [ ] Test unique constraints
- [ ] Test indexes work correctly

### File Storage
- [ ] Verify storage directories exist
- [ ] Test file upload to storage/app/public
- [ ] Test symlink to public/storage
- [ ] Test file deletion

### JWT
- [ ] Test JWT secret is set
- [ ] Test token generation
- [ ] Test token validation
- [ ] Test token expiration
- [ ] Test token refresh

## Edge Cases

- [ ] Test with very long text inputs
- [ ] Test with special characters in inputs
- [ ] Test with null values
- [ ] Test with empty strings
- [ ] Test with future dates
- [ ] Test with past dates
- [ ] Test with timezone differences
- [ ] Test concurrent clock in/out

## Documentation Verification

- [ ] Verify all endpoints documented in README
- [ ] Verify request examples are correct
- [ ] Verify response examples are accurate
- [ ] Test all curl examples work
- [ ] Verify error codes are documented

## Checklist Summary

Total tests: ~150+
Required pass rate: 100% for critical endpoints

### Critical Endpoints (Must Pass)
- Authentication (login, logout, refresh)
- Attendance (clock in, clock out)
- Profile (get, update)

### Important Endpoints (Should Pass)
- Leave management
- Overtime management
- Notifications

### Nice-to-Have Endpoints (Can be implemented later)
- Payslip PDF download
- Password reset functionality
- Advanced reporting

## Notes

- This checklist should be run after every major change
- Automated tests should be created for critical paths
- Consider using Postman or similar tools for API testing
- Document any bugs found in GitHub issues
