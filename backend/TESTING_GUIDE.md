# Testing Guide - AbsenKantor Backend API

## Quick Start Testing

### 1. Start the Server

```bash
cd backend
php artisan serve
```

Server will run on `http://localhost:8000`

### 2. Test Authentication

#### Login (Get JWT Token)
```bash
curl -X POST http://localhost:8000/api/auth/login \
  -H "Content-Type: application/json" \
  -d '{
    "username": "admin",
    "password": "password123"
  }'
```

**Expected Response:**
```json
{
  "success": true,
  "message": "Login berhasil",
  "data": {
    "token": "eyJ0eXAiOiJKV1QiLCJhbGc...",
    "token_type": "bearer",
    "expires_in": 3600,
    "user": {
      "id": 1,
      "username": "admin",
      "email": "admin@absenkantor.com",
      "role": "admin"
    }
  }
}
```

Save the token for subsequent requests.

### 3. Test Protected Endpoints

#### Get Profile
```bash
curl -X GET http://localhost:8000/api/profile \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -H "Content-Type: application/json"
```

#### Get Today's Attendance
```bash
curl -X GET http://localhost:8000/api/attendance/today \
  -H "Authorization: Bearer YOUR_TOKEN_HERE"
```

#### List Leave Types
```bash
curl -X GET http://localhost:8000/api/leaves/types \
  -H "Authorization: Bearer YOUR_TOKEN_HERE"
```

#### Get Attendance Locations
```bash
curl -X GET http://localhost:8000/api/attendance/locations \
  -H "Authorization: Bearer YOUR_TOKEN_HERE"
```

### 4. Test Clock In (with Photo)

```bash
curl -X POST http://localhost:8000/api/attendance/clock-in \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -F "latitude=-6.208763" \
  -F "longitude=106.845599" \
  -F "photo=@/path/to/photo.jpg" \
  -F "address=Kantor Pusat Jakarta"
```

### 5. Test Leave Request

```bash
curl -X POST http://localhost:8000/api/leaves \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -H "Content-Type: application/json" \
  -d '{
    "leave_type_id": 1,
    "start_date": "2024-12-10",
    "end_date": "2024-12-12",
    "reason": "Family vacation for year end holidays"
  }'
```

## Test with Postman

### Import Collection

Create a Postman collection with these base settings:

**Base URL:** `http://localhost:8000`

**Headers (for protected routes):**
```
Authorization: Bearer {{token}}
Content-Type: application/json
```

### Test Sequence

1. **Login** → Save token to environment variable
2. **Get Profile** → Verify user data
3. **Get Attendance Locations** → Check available locations
4. **Clock In** → Submit attendance
5. **Get Today's Attendance** → Verify clock in recorded
6. **Clock Out** → Complete attendance
7. **Get Attendance History** → View records
8. **Get Leave Types** → Check available leave types
9. **Get Leave Balance** → Check quota
10. **Submit Leave Request** → Create new request
11. **Get Leave Requests** → View list

## API Response Standards

All API responses follow this format:

### Success Response
```json
{
  "success": true,
  "message": "Operation successful",
  "data": {
    // Response data here
  }
}
```

### Error Response
```json
{
  "success": false,
  "message": "Error message here",
  "errors": {
    "field": ["Error detail"]
  }
}
```

## Test Data Available

After running `php artisan db:seed`:

### Users
1. **Admin**
   - Username: admin
   - Password: password123
   - Role: admin

2. **Employee 1**
   - Username: employee1
   - Password: password123
   - Name: Budi Santoso
   - Department: IT

3. **Employee 2**
   - Username: employee2
   - Password: password123
   - Name: Siti Nurhaliza
   - Department: HR

4. **Employee 3**
   - Username: employee3
   - Password: password123
   - Name: Ahmad Rifai
   - Department: Finance

### Attendance Locations
1. Kantor Pusat - Main Building (Lat: -6.208763, Long: 106.845599, Radius: 100m)
2. Kantor Pusat - Parking Area (Lat: -6.208863, Long: 106.845699, Radius: 50m)
3. Work From Home (Unlimited radius)

### Leave Types
1. Cuti Tahunan (Annual Leave) - 12 days/year
2. Cuti Sakit (Sick Leave) - 12 days/year
3. Cuti Tanpa Gaji (Unpaid Leave) - 0 days

### Work Shift
- Regular Office Hours: 08:00 - 17:00 (8 working hours)

## Common Test Scenarios

### Scenario 1: Employee Daily Attendance
1. Login as employee1
2. Check today's attendance (should be null if not clocked in)
3. Clock in at office location
4. Verify clock in recorded
5. After work, clock out
6. Check attendance history

### Scenario 2: Late Arrival
1. Login as employee
2. Clock in after 08:15 (late tolerance)
3. System should mark as late
4. Check late duration in attendance record

### Scenario 3: Leave Request
1. Login as employee
2. Check leave balance
3. Submit leave request for future dates
4. Verify balance not yet deducted (pending approval)
5. View leave request status

### Scenario 4: GPS Validation
1. Login as employee
2. Try to clock in with coordinates far from office
3. Should receive error about location
4. Clock in with valid coordinates
5. Should succeed

### Scenario 5: Profile Update
1. Login as employee
2. Get current profile
3. Update phone number and address
4. Upload avatar photo
5. Verify updates saved

## Testing Geofencing

### Valid Location (Should Success)
```json
{
  "latitude": -6.208763,
  "longitude": 106.845599
}
```

### Invalid Location (Should Fail)
```json
{
  "latitude": -6.300000,
  "longitude": 106.900000
}
```

The system uses Haversine formula to calculate distance and validates against the radius set for each attendance location.

## API Endpoint Checklist

### Authentication ✓
- [ ] POST /api/auth/login
- [ ] POST /api/auth/logout
- [ ] POST /api/auth/refresh
- [ ] POST /api/auth/forgot-password
- [ ] POST /api/auth/reset-password

### Profile ✓
- [ ] GET /api/profile
- [ ] PUT /api/profile
- [ ] PUT /api/profile/password
- [ ] POST /api/profile/avatar

### Attendance ✓
- [ ] POST /api/attendance/clock-in
- [ ] POST /api/attendance/clock-out
- [ ] GET /api/attendance/today
- [ ] GET /api/attendance/history
- [ ] GET /api/attendance/summary
- [ ] GET /api/attendance/locations

### Leave ✓
- [ ] GET /api/leaves
- [ ] POST /api/leaves
- [ ] GET /api/leaves/{id}
- [ ] DELETE /api/leaves/{id}
- [ ] GET /api/leaves/types
- [ ] GET /api/leaves/balance

### Overtime ✓
- [ ] GET /api/overtimes
- [ ] POST /api/overtimes
- [ ] GET /api/overtimes/{id}

### Schedule ✓
- [ ] GET /api/schedules
- [ ] GET /api/schedules/shifts
- [ ] GET /api/holidays

### Payroll ✓
- [ ] GET /api/payslips
- [ ] GET /api/payslips/{id}
- [ ] GET /api/payslips/{id}/download

### Notifications ✓
- [ ] GET /api/notifications
- [ ] PUT /api/notifications/{id}/read
- [ ] PUT /api/notifications/read-all

### Announcements ✓
- [ ] GET /api/announcements

## Troubleshooting

### Issue: 401 Unauthorized
**Solution:** Check if token is valid and not expired. Login again to get new token.

### Issue: 500 Internal Server Error
**Solution:** Check `storage/logs/laravel.log` for detailed error message.

### Issue: Database connection error
**Solution:** Verify `.env` database configuration and ensure database exists.

### Issue: Token generation fails
**Solution:** Run `php artisan jwt:secret` to generate JWT secret.

### Issue: File upload fails
**Solution:** Ensure `storage/app/public` directory exists and is writable.

## Performance Testing

### Load Test with Apache Bench
```bash
ab -n 1000 -c 10 -H "Authorization: Bearer YOUR_TOKEN" \
  http://localhost:8000/api/profile
```

### Expected Performance
- Simple GET requests: < 50ms
- POST with validation: < 100ms
- File uploads: < 500ms
- Geofence calculation: < 10ms

## Security Testing

### Test Cases
1. Access protected route without token → Should return 401
2. Access with expired token → Should return 401
3. Access with invalid token → Should return 401
4. SQL injection attempts → Should be prevented by Eloquent
5. XSS attempts → Should be sanitized
6. File upload with invalid type → Should be rejected

## Next Steps

After basic testing:
1. Test with mobile application
2. Load testing under concurrent users
3. Integration with external services
4. Deploy to staging environment
5. User acceptance testing

## Support

For issues or questions:
- Check `storage/logs/laravel.log`
- Review API documentation in README.md
- Verify all requirements are installed
- Ensure database migrations ran successfully

---

**Happy Testing! 🚀**
