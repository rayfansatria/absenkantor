# AbsenKantor API Documentation

Base URL: `http://localhost:8000/api`

## Authentication

All protected endpoints require a JWT token in the Authorization header:
```
Authorization: Bearer {token}
```

### POST /auth/login
Login and receive JWT token.

**Request Body:**
```json
{
  "username": "john.doe",
  "password": "password123"
}
```

**Response (200 OK):**
```json
{
  "success": true,
  "token": "eyJ0eXAiOiJKV1QiLCJhbGc...",
  "user": {
    "id": 1,
    "username": "john.doe",
    "email": "john@example.com",
    "name": "John Doe",
    "phone": "+6281234567890",
    "avatar": null,
    "employee_id": 1,
    "institution_id": 1
  }
}
```

**Error Response (401 Unauthorized):**
```json
{
  "success": false,
  "message": "Invalid credentials"
}
```

### POST /auth/logout
Logout and invalidate token.

**Headers:** Authorization required

**Response (200 OK):**
```json
{
  "success": true,
  "message": "Successfully logged out"
}
```

### POST /auth/refresh
Refresh JWT token.

**Headers:** Authorization required

**Response (200 OK):**
```json
{
  "success": true,
  "token": "eyJ0eXAiOiJKV1QiLCJhbGc..."
}
```

### POST /auth/forgot-password
Request password reset link.

**Request Body:**
```json
{
  "email": "john@example.com"
}
```

**Response (200 OK):**
```json
{
  "success": true,
  "message": "Password reset link has been sent to your email"
}
```

### POST /auth/reset-password
Reset password with token.

**Request Body:**
```json
{
  "email": "john@example.com",
  "token": "reset_token_here",
  "password": "newpassword123",
  "password_confirmation": "newpassword123"
}
```

## Profile Management

### GET /profile
Get current user profile.

**Headers:** Authorization required

**Response (200 OK):**
```json
{
  "success": true,
  "data": {
    "id": 1,
    "username": "john.doe",
    "email": "john@example.com",
    "name": "John Doe",
    "phone": "+6281234567890",
    "avatar": "avatars/john.jpg",
    "employee": {
      "id": 1,
      "employee_number": "EMP001",
      "full_name": "John Doe",
      "department": {
        "id": 1,
        "name": "IT Department"
      },
      "position": {
        "id": 1,
        "name": "Software Developer"
      }
    }
  }
}
```

### PUT /profile
Update user profile.

**Headers:** Authorization required

**Request Body:**
```json
{
  "name": "John Updated",
  "phone": "+6281234567891"
}
```

**Response (200 OK):**
```json
{
  "success": true,
  "data": {
    "id": 1,
    "username": "john.doe",
    "email": "john@example.com",
    "name": "John Updated",
    "phone": "+6281234567891"
  }
}
```

### PUT /profile/password
Change password.

**Headers:** Authorization required

**Request Body:**
```json
{
  "old_password": "oldpassword123",
  "new_password": "newpassword123",
  "new_password_confirmation": "newpassword123"
}
```

**Response (200 OK):**
```json
{
  "success": true,
  "message": "Password changed successfully"
}
```

### POST /profile/avatar
Upload profile avatar.

**Headers:** Authorization required

**Request Body (multipart/form-data):**
```
avatar: [file]
```

**Response (200 OK):**
```json
{
  "success": true,
  "data": {
    "id": 1,
    "avatar": "avatars/john_123456.jpg"
  }
}
```

## Attendance Management

### POST /attendance/clock-in
Clock in for today.

**Headers:** Authorization required

**Request Body (multipart/form-data):**
```
latitude: -6.123456
longitude: 106.123456
photo: [file]
notes: "On time"
```

**Response (200 OK):**
```json
{
  "success": true,
  "data": {
    "id": 1,
    "employee_id": 1,
    "date": "2024-12-04",
    "clock_in": "2024-12-04 08:00:00",
    "clock_in_latitude": -6.123456,
    "clock_in_longitude": 106.123456,
    "clock_in_photo": "attendance/photo_123456.jpg",
    "clock_in_notes": "On time",
    "status": "present"
  }
}
```

**Error Response (400 Bad Request):**
```json
{
  "success": false,
  "message": "You are not in valid attendance location"
}
```

### POST /attendance/clock-out
Clock out for today.

**Headers:** Authorization required

**Request Body (multipart/form-data):**
```
latitude: -6.123456
longitude: 106.123456
photo: [file]
notes: "Completed work"
```

**Response (200 OK):**
```json
{
  "success": true,
  "data": {
    "id": 1,
    "employee_id": 1,
    "date": "2024-12-04",
    "clock_in": "2024-12-04 08:00:00",
    "clock_out": "2024-12-04 17:00:00",
    "status": "present",
    "work_hours": 9
  }
}
```

### GET /attendance/today
Get today's attendance status.

**Headers:** Authorization required

**Response (200 OK):**
```json
{
  "success": true,
  "data": {
    "id": 1,
    "employee_id": 1,
    "date": "2024-12-04",
    "clock_in": "2024-12-04 08:00:00",
    "clock_out": null,
    "status": "present",
    "is_late": false
  }
}
```

### GET /attendance/history
Get attendance history.

**Headers:** Authorization required

**Query Parameters:**
- `month` (optional): Month number (1-12)
- `year` (optional): Year (e.g., 2024)
- `page` (optional): Page number

**Response (200 OK):**
```json
{
  "success": true,
  "data": {
    "current_page": 1,
    "data": [
      {
        "id": 1,
        "date": "2024-12-04",
        "clock_in": "2024-12-04 08:00:00",
        "clock_out": "2024-12-04 17:00:00",
        "status": "present",
        "is_late": false,
        "work_hours": 9
      }
    ],
    "per_page": 20,
    "total": 1
  }
}
```

### GET /attendance/summary
Get monthly attendance summary.

**Headers:** Authorization required

**Query Parameters:**
- `month`: Month number (1-12)
- `year`: Year (e.g., 2024)

**Response (200 OK):**
```json
{
  "success": true,
  "data": {
    "total_days": 20,
    "present": 18,
    "late": 2,
    "absent": 0,
    "on_leave": 2
  }
}
```

### GET /attendance/locations
Get valid attendance locations.

**Headers:** Authorization required

**Response (200 OK):**
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "name": "Head Office",
      "address": "Jl. Sudirman No. 123, Jakarta",
      "latitude": -6.123456,
      "longitude": 106.123456,
      "radius": 100
    }
  ]
}
```

## Leave Management

### GET /leaves
Get leave requests.

**Headers:** Authorization required

**Query Parameters:**
- `status` (optional): pending, approved, rejected, cancelled
- `page` (optional): Page number

**Response (200 OK):**
```json
{
  "success": true,
  "data": []
}
```

### POST /leaves
Create leave request.

**Headers:** Authorization required

**Request Body:**
```json
{
  "leave_type_id": 1,
  "start_date": "2024-12-10",
  "end_date": "2024-12-12",
  "total_days": 3,
  "reason": "Family vacation",
  "delegate_to_employee_id": 2
}
```

### GET /leaves/{id}
Get leave request details.

### DELETE /leaves/{id}
Cancel leave request.

### GET /leaves/types
Get available leave types.

### GET /leaves/balance
Get employee leave balance.

## Other Endpoints

Similar structure for:
- Overtime Management (`/overtimes`)
- Schedule Management (`/schedules`)
- Payroll Management (`/payslips`)
- Notifications (`/notifications`)
- Announcements (`/announcements`)

## Error Responses

### 401 Unauthorized
```json
{
  "success": false,
  "message": "Unauthenticated"
}
```

### 422 Validation Error
```json
{
  "success": false,
  "message": "Validation error",
  "errors": {
    "username": ["The username field is required."],
    "password": ["The password field is required."]
  }
}
```

### 500 Server Error
```json
{
  "success": false,
  "message": "Internal server error"
}
```
