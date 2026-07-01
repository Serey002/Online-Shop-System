# User Profile Management API Documentation

This document describes the API endpoints and web interface for managing user profiles, including updating profile information, changing passwords, and uploading profile images.

---

## Web Interface (Admin Panel)

### Access Profile Settings
- **URL**: `/admin/settings`
- **Method**: `GET`
- **Authentication**: Required (Admin session)
- **Description**: Display the profile settings page

### Update Profile (Web)
- **URL**: `/admin/settings`
- **Method**: `PUT`
- **Authentication**: Required (Admin session)
- **Content-Type**: `multipart/form-data`

**Form Fields:**
```
name: string (required, max: 255)
email: string (required, email, unique)
phone: string (optional, max: 20)
image: file (optional, jpeg/png/jpg/webp, max: 2MB)
current_password: string (optional, required if changing password)
new_password: string (optional, min: 8, must be confirmed)
new_password_confirmation: string (optional, must match new_password)
```

**Features:**
- ✅ Update full name
- ✅ Update email address
- ✅ Update phone number
- ✅ Upload/change profile image
- ✅ Change password with current password verification
- ✅ Live image preview before upload
- ✅ Automatic old image deletion when uploading new one

---

## API Endpoints

### 1. Get Current User Profile

**Endpoint:** `GET /api/user`

**Headers:**
```
Authorization: Bearer {your_access_token}
Accept: application/json
```

**Response (200 OK):**
```json
{
  "id": 1,
  "name": "John Doe",
  "email": "john@example.com",
  "phone": "+1234567890",
  "image": "profiles/abc123.jpg",
  "role": "customer",
  "created_at": "2024-01-01T00:00:00.000000Z",
  "updated_at": "2024-01-01T00:00:00.000000Z"
}
```

---

### 2. Update User Profile

**Endpoint:** `PUT /api/user/profile` or `POST /api/user/profile`

**Note:** Use `POST` when uploading images (multipart/form-data), use `PUT` for JSON updates without images.

**Headers:**
```
Authorization: Bearer {your_access_token}
Content-Type: multipart/form-data  (for image upload)
Content-Type: application/json     (for JSON data only)
```

**Request Body (JSON - without image):**
```json
{
  "name": "John Doe",
  "email": "john@example.com",
  "phone": "+1234567890"
}
```

**Request Body (Form Data - with image):**
```
name: John Doe
email: john@example.com
phone: +1234567890
image: [binary file data]
```

**Validation Rules:**
- `name`: required, string, max 255 characters
- `email`: required, valid email, unique (except current user)
- `phone`: optional, string, max 20 characters
- `image`: optional, image file (jpeg/png/jpg/webp), max 2MB

**Response (200 OK):**
```json
{
  "status": "success",
  "message": "Your profile information has been updated successfully!",
  "user": {
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com",
    "phone": "+1234567890",
    "image_url": "http://yourapp.com/storage/profiles/abc123.jpg"
  }
}
```

**Error Response (422 Unprocessable Entity):**
```json
{
  "message": "The email has already been taken.",
  "errors": {
    "email": [
      "The email has already been taken."
    ]
  }
}
```

---

### 3. Change Password

**Endpoint:** `PUT /api/user/change-password`

**Headers:**
```
Authorization: Bearer {your_access_token}
Content-Type: application/json
```

**Request Body:**
```json
{
  "current_password": "oldpassword123",
  "new_password": "newpassword123",
  "new_password_confirmation": "newpassword123"
}
```

**Validation Rules:**
- `current_password`: required, string
- `new_password`: required, string, minimum 8 characters, must be confirmed
- `new_password_confirmation`: required, must match new_password

**Response (200 OK):**
```json
{
  "status": "success",
  "message": "Your password has been changed successfully!"
}
```

**Error Response (422 Unprocessable Entity):**
```json
{
  "status": "error",
  "message": "The current password is incorrect.",
  "errors": {
    "current_password": [
      "The current password is incorrect."
    ]
  }
}
```

---

## Usage Examples

### Example 1: Update Profile with cURL (JSON)

```bash
curl -X PUT http://yourapp.com/api/user/profile \
  -H "Authorization: Bearer your_access_token" \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Jane Smith",
    "email": "jane@example.com",
    "phone": "+1987654321"
  }'
```

### Example 2: Update Profile with Image (cURL)

```bash
curl -X POST http://yourapp.com/api/user/profile \
  -H "Authorization: Bearer your_access_token" \
  -F "name=Jane Smith" \
  -F "email=jane@example.com" \
  -F "phone=+1987654321" \
  -F "image=@/path/to/profile.jpg"
```

### Example 3: Change Password (cURL)

```bash
curl -X PUT http://yourapp.com/api/user/change-password \
  -H "Authorization: Bearer your_access_token" \
  -H "Content-Type: application/json" \
  -d '{
    "current_password": "oldpass123",
    "new_password": "newpass123",
    "new_password_confirmation": "newpass123"
  }'
```

### Example 4: JavaScript/Axios (Update Profile with Image)

```javascript
const formData = new FormData();
formData.append('name', 'Jane Smith');
formData.append('email', 'jane@example.com');
formData.append('phone', '+1987654321');
formData.append('image', fileInput.files[0]); // File from input element

axios.post('/api/user/profile', formData, {
  headers: {
    'Authorization': `Bearer ${accessToken}`,
    'Content-Type': 'multipart/form-data'
  }
})
.then(response => {
  console.log('Profile updated:', response.data);
})
.catch(error => {
  console.error('Error:', error.response.data);
});
```

### Example 5: JavaScript/Axios (Change Password)

```javascript
axios.put('/api/user/change-password', {
  current_password: 'oldpass123',
  new_password: 'newpass123',
  new_password_confirmation: 'newpass123'
}, {
  headers: {
    'Authorization': `Bearer ${accessToken}`,
    'Content-Type': 'application/json'
  }
})
.then(response => {
  console.log('Password changed:', response.data);
})
.catch(error => {
  console.error('Error:', error.response.data);
});
```

---

## Important Notes

1. **Image Storage**: Profile images are stored in `storage/app/public/profiles/` directory
2. **Image Access**: Images are accessible via `/storage/profiles/{filename}`
3. **Old Image Cleanup**: When uploading a new profile image, the old image is automatically deleted
4. **Password Security**: Current password must be verified before changing to a new password
5. **Email Uniqueness**: Email addresses must be unique across all users
6. **File Size Limit**: Maximum profile image size is 2MB (20048 KB)
7. **Supported Formats**: JPEG, PNG, JPG, WEBP

---

## Security Considerations

- All profile update endpoints require authentication via Laravel Sanctum
- Passwords are hashed using bcrypt before storage
- Current password verification is required for password changes
- Email uniqueness is enforced at the database level
- File upload validation prevents malicious file uploads
- Old profile images are securely deleted when replaced

---

## Testing the Implementation

### Test Web Interface:
1. Login to admin panel at `/admin/login`
2. Navigate to `/admin/settings`
3. Update your profile information
4. Upload a profile image
5. Change your password

### Test API Endpoints:
1. Obtain an access token via `/api/login` or `/api/register`
2. Use the token in the Authorization header
3. Test profile updates with Postman or cURL
4. Verify image uploads work correctly
5. Test password change functionality

---

## Error Codes

- `200`: Success
- `401`: Unauthorized (invalid or missing token)
- `422`: Validation Error (invalid input data)
- `500`: Server Error

---

## Support

For issues or questions, please contact the development team or create an issue in the project repository.
