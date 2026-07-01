# Complete API Endpoints Documentation

## Base URL
```
http://localhost:8000/api
```

---

## Table of Contents
1. [Authentication Endpoints](#authentication-endpoints)
2. [User Profile Endpoints](#user-profile-endpoints)
3. [Product Endpoints](#product-endpoints)
4. [Category Endpoints](#category-endpoints)
5. [Order Endpoints](#order-endpoints)
6. [Review Endpoints](#review-endpoints)

---

## Authentication Endpoints

### 1. Register New User

**Endpoint:** `POST /api/register`

**Authentication:** Not required

**Request Headers:**
```json
{
  "Content-Type": "application/json",
  "Accept": "application/json"
}
```

**Request Body:**
```json
{
  "name": "John Doe",
  "email": "john@example.com",
  "phone": "+1234567890",
  "password": "password123"
}
```

**Validation Rules:**
- `name`: required, string, max 255 characters
- `email`: required, valid email, unique
- `phone`: optional, string, max 20 characters
- `password`: required, string, min 8 characters

**Success Response (201 Created):**
```json
{
  "status": "success",
  "message": "User registered successfully",
  "access_token": "1|abcdefghijklmnopqrstuvwxyz1234567890",
  "token_type": "Bearer",
  "user": {
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com",
    "phone": "+1234567890",
    "role": "customer",
    "created_at": "2024-01-01T00:00:00.000000Z",
    "updated_at": "2024-01-01T00:00:00.000000Z"
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

### 2. Login User

**Endpoint:** `POST /api/login`

**Authentication:** Not required

**Request Headers:**
```json
{
  "Content-Type": "application/json",
  "Accept": "application/json"
}
```

**Request Body:**
```json
{
  "email": "john@example.com",
  "password": "password123"
}
```

**Validation Rules:**
- `email`: required, valid email
- `password`: required, string

**Success Response (200 OK):**
```json
{
  "status": "success",
  "message": "Authenticated successfully",
  "access_token": "2|xyz123abc456def789ghi012jkl345mno678",
  "token_type": "Bearer",
  "user": {
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com",
    "phone": "+1234567890",
    "image_url": "http://localhost:8000/storage/profiles/abc123.jpg"
  }
}
```

**Error Response (401 Unauthorized):**
```json
{
  "status": "error",
  "message": "Invalid authentication credentials."
}
```

---

### 3. Logout User

**Endpoint:** `POST /api/logout`

**Authentication:** Required (Bearer Token)

**Request Headers:**
```json
{
  "Authorization": "Bearer YOUR_ACCESS_TOKEN",
  "Accept": "application/json"
}
```

**Request Body:** None

**Success Response (200 OK):**
```json
{
  "status": "success",
  "message": "Tokens revoked and session signed out successfully."
}
```

---

## User Profile Endpoints

### 4. Get Current User Profile

**Endpoint:** `GET /api/user`

**Authentication:** Required (Bearer Token)

**Request Headers:**
```json
{
  "Authorization": "Bearer YOUR_ACCESS_TOKEN",
  "Accept": "application/json"
}
```

**Request Body:** None

**Success Response (200 OK):**
```json
{
  "id": 1,
  "name": "John Doe",
  "email": "john@example.com",
  "phone": "+1234567890",
  "image": "profiles/abc123.jpg",
  "role": "customer",
  "email_verified_at": null,
  "created_at": "2024-01-01T00:00:00.000000Z",
  "updated_at": "2024-01-01T00:00:00.000000Z"
}
```

---

### 5. Update User Profile (JSON)

**Endpoint:** `PUT /api/user/profile`

**Authentication:** Required (Bearer Token)

**Request Headers:**
```json
{
  "Authorization": "Bearer YOUR_ACCESS_TOKEN",
  "Content-Type": "application/json",
  "Accept": "application/json"
}
```

**Request Body:**
```json
{
  "name": "Jane Smith",
  "email": "jane@example.com",
  "phone": "+1987654321"
}
```

**Validation Rules:**
- `name`: required, string, max 255 characters
- `email`: required, valid email, unique (except current user)
- `phone`: optional, string, max 20 characters

**Success Response (200 OK):**
```json
{
  "status": "success",
  "message": "Your profile information has been updated successfully!",
  "user": {
    "id": 1,
    "name": "Jane Smith",
    "email": "jane@example.com",
    "phone": "+1987654321",
    "image_url": "http://localhost:8000/storage/profiles/abc123.jpg"
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

### 6. Update User Profile with Image

**Endpoint:** `POST /api/user/profile`

**Authentication:** Required (Bearer Token)

**Request Headers:**
```json
{
  "Authorization": "Bearer YOUR_ACCESS_TOKEN",
  "Content-Type": "multipart/form-data",
  "Accept": "application/json"
}
```

**Request Body (Form Data):**
```
name: Jane Smith
email: jane@example.com
phone: +1987654321
image: [binary file data]
```

**Validation Rules:**
- `name`: required, string, max 255 characters
- `email`: required, valid email, unique (except current user)
- `phone`: optional, string, max 20 characters
- `image`: optional, image file (jpeg/png/jpg/webp), max 2MB

**Success Response (200 OK):**
```json
{
  "status": "success",
  "message": "Your profile information has been updated successfully!",
  "user": {
    "id": 1,
    "name": "Jane Smith",
    "email": "jane@example.com",
    "phone": "+1987654321",
    "image_url": "http://localhost:8000/storage/profiles/new_image.jpg"
  }
}
```

---

### 7. Change Password

**Endpoint:** `PUT /api/user/change-password`

**Authentication:** Required (Bearer Token)

**Request Headers:**
```json
{
  "Authorization": "Bearer YOUR_ACCESS_TOKEN",
  "Content-Type": "application/json",
  "Accept": "application/json"
}
```

**Request Body:**
```json
{
  "current_password": "oldpassword123",
  "new_password": "newpassword456",
  "new_password_confirmation": "newpassword456"
}
```

**Validation Rules:**
- `current_password`: required, string
- `new_password`: required, string, min 8 characters, must be confirmed
- `new_password_confirmation`: required, must match new_password

**Success Response (200 OK):**
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

## Product Endpoints

### 8. Get All Products

**Endpoint:** `GET /api/products`

**Authentication:** Not required

**Request Headers:**
```json
{
  "Accept": "application/json"
}
```

**Query Parameters:**
- `search` (optional): Search products by name
- `category_id` (optional): Filter by category ID

**Example Request:**
```
GET /api/products?search=pizza&category_id=1
```

**Success Response (200 OK):**
```json
{
  "status": "success",
  "count": 2,
  "data": [
    {
      "id": 1,
      "name": "Pepperoni Pizza",
      "description": "Delicious pizza with pepperoni",
      "price": "15.99",
      "stock": 50,
      "category_id": 1,
      "image": "products/pizza1.jpg",
      "image_url": "http://localhost:8000/storage/products/pizza1.jpg",
      "created_at": "2024-01-01T00:00:00.000000Z",
      "updated_at": "2024-01-01T00:00:00.000000Z",
      "reviews_count": 5,
      "reviews_avg_rating": 4.5,
      "average_rating": 4.5,
      "category": {
        "id": 1,
        "name": "Pizza",
        "description": "Various pizza types",
        "created_at": "2024-01-01T00:00:00.000000Z",
        "updated_at": "2024-01-01T00:00:00.000000Z"
      }
    },
    {
      "id": 2,
      "name": "Margherita Pizza",
      "description": "Classic Italian pizza",
      "price": "12.99",
      "stock": 30,
      "category_id": 1,
      "image": "products/pizza2.jpg",
      "image_url": "http://localhost:8000/storage/products/pizza2.jpg",
      "created_at": "2024-01-01T00:00:00.000000Z",
      "updated_at": "2024-01-01T00:00:00.000000Z",
      "reviews_count": 3,
      "reviews_avg_rating": 4.7,
      "average_rating": 4.7,
      "category": {
        "id": 1,
        "name": "Pizza",
        "description": "Various pizza types",
        "created_at": "2024-01-01T00:00:00.000000Z",
        "updated_at": "2024-01-01T00:00:00.000000Z"
      }
    }
  ]
}
```

---

### 9. Get Single Product

**Endpoint:** `GET /api/products/{id}`

**Authentication:** Not required

**Request Headers:**
```json
{
  "Accept": "application/json"
}
```

**Example Request:**
```
GET /api/products/1
```

**Success Response (200 OK):**
```json
{
  "status": "success",
  "data": {
    "id": 1,
    "name": "Pepperoni Pizza",
    "description": "Delicious pizza with pepperoni and cheese",
    "price": "15.99",
    "stock": 50,
    "category_id": 1,
    "image": "products/pizza1.jpg",
    "image_url": "http://localhost:8000/storage/products/pizza1.jpg",
    "created_at": "2024-01-01T00:00:00.000000Z",
    "updated_at": "2024-01-01T00:00:00.000000Z",
    "reviews_count": 5,
    "reviews_avg_rating": 4.5,
    "average_rating": 4.5,
    "category": {
      "id": 1,
      "name": "Pizza",
      "description": "Various pizza types",
      "created_at": "2024-01-01T00:00:00.000000Z",
      "updated_at": "2024-01-01T00:00:00.000000Z"
    },
    "reviews": [
      {
        "id": 1,
        "user_id": 2,
        "product_id": 1,
        "rating": 5,
        "comment": "Amazing pizza!",
        "created_at": "2024-01-02T00:00:00.000000Z",
        "updated_at": "2024-01-02T00:00:00.000000Z",
        "user": {
          "id": 2,
          "name": "Alice Johnson"
        }
      }
    ]
  }
}
```

**Error Response (404 Not Found):**
```json
{
  "status": "error",
  "message": "Product record item not found"
}
```

---

## Category Endpoints

### 10. Get All Categories

**Endpoint:** `GET /api/categories`

**Authentication:** Not required

**Request Headers:**
```json
{
  "Accept": "application/json"
}
```

**Success Response (200 OK):**
```json
{
  "status": "success",
  "count": 3,
  "data": [
    {
      "id": 1,
      "name": "Pizza",
      "description": "Various types of pizza",
      "created_at": "2024-01-01T00:00:00.000000Z",
      "updated_at": "2024-01-01T00:00:00.000000Z"
    },
    {
      "id": 2,
      "name": "Burgers",
      "description": "Delicious burgers",
      "created_at": "2024-01-01T00:00:00.000000Z",
      "updated_at": "2024-01-01T00:00:00.000000Z"
    },
    {
      "id": 3,
      "name": "Beverages",
      "description": "Drinks and beverages",
      "created_at": "2024-01-01T00:00:00.000000Z",
      "updated_at": "2024-01-01T00:00:00.000000Z"
    }
  ]
}
```

---

## Order Endpoints

### 11. Get User Orders

**Endpoint:** `GET /api/orders`

**Authentication:** Required (Bearer Token)

**Request Headers:**
```json
{
  "Authorization": "Bearer YOUR_ACCESS_TOKEN",
  "Accept": "application/json"
}
```

**Success Response (200 OK):**
```json
{
  "status": "success",
  "count": 2,
  "data": [
    {
      "id": 1,
      "user_id": 1,
      "total_price": "45.97",
      "total_amount": "45.97",
      "items_summary": "2x Pepperoni Pizza, 1x Coca Cola",
      "notes": "Extra cheese please",
      "status": "preparing",
      "created_at": "2024-01-05T10:30:00.000000Z",
      "updated_at": "2024-01-05T10:35:00.000000Z"
    },
    {
      "id": 2,
      "user_id": 1,
      "total_price": "28.98",
      "total_amount": "28.98",
      "items_summary": "1x Cheeseburger, 1x Fries, 1x Sprite",
      "notes": null,
      "status": "served & done",
      "created_at": "2024-01-04T14:20:00.000000Z",
      "updated_at": "2024-01-04T15:00:00.000000Z"
    }
  ]
}
```

---

### 12. Create New Order

**Endpoint:** `POST /api/orders`

**Authentication:** Required (Bearer Token)

**Request Headers:**
```json
{
  "Authorization": "Bearer YOUR_ACCESS_TOKEN",
  "Content-Type": "application/json",
  "Accept": "application/json"
}
```

**Request Body:**
```json
{
  "total_price": 45.97,
  "items_summary": "2x Pepperoni Pizza, 1x Coca Cola",
  "notes": "Extra cheese please"
}
```

**Validation Rules:**
- `total_price`: required, numeric, min 0
- `items_summary`: required, string, max 500 characters
- `notes`: optional, string, max 255 characters

**Success Response (201 Created):**
```json
{
  "status": "success",
  "message": "Your food kitchen order ticket has been successfully registered!",
  "data": {
    "id": 3,
    "user_id": 1,
    "total_price": "45.97",
    "total_amount": "45.97",
    "items_summary": "2x Pepperoni Pizza, 1x Coca Cola",
    "notes": "Extra cheese please",
    "status": "pending",
    "created_at": "2024-01-06T12:00:00.000000Z",
    "updated_at": "2024-01-06T12:00:00.000000Z"
  }
}
```

**Error Response (422 Unprocessable Entity):**
```json
{
  "message": "The total price field is required.",
  "errors": {
    "total_price": [
      "The total price field is required."
    ]
  }
}
```

---

### 13. Get Single Order

**Endpoint:** `GET /api/orders/{id}`

**Authentication:** Required (Bearer Token)

**Request Headers:**
```json
{
  "Authorization": "Bearer YOUR_ACCESS_TOKEN",
  "Accept": "application/json"
}
```

**Example Request:**
```
GET /api/orders/1
```

**Success Response (200 OK):**
```json
{
  "status": "success",
  "data": {
    "id": 1,
    "user_id": 1,
    "total_price": "45.97",
    "total_amount": "45.97",
    "items_summary": "2x Pepperoni Pizza, 1x Coca Cola",
    "notes": "Extra cheese please",
    "status": "preparing",
    "created_at": "2024-01-05T10:30:00.000000Z",
    "updated_at": "2024-01-05T10:35:00.000000Z"
  }
}
```

**Error Response (404 Not Found):**
```json
{
  "status": "error",
  "message": "Order document entry not found or unauthorized access."
}
```

---

### 14. Update Order Status

**Endpoint:** `PATCH /api/orders/{id}/status`

**Authentication:** Required (Bearer Token)

**Request Headers:**
```json
{
  "Authorization": "Bearer YOUR_ACCESS_TOKEN",
  "Content-Type": "application/json",
  "Accept": "application/json"
}
```

**Request Body:**
```json
{
  "status": "with courier"
}
```

**Validation Rules:**
- `status`: required, string, must be one of: `preparing`, `with courier`, `served & done`, `cancelled`

**Success Response (200 OK):**
```json
{
  "status": "success",
  "message": "Status updated successfully",
  "data": {
    "id": 1,
    "user_id": 1,
    "total_price": "45.97",
    "total_amount": "45.97",
    "items_summary": "2x Pepperoni Pizza, 1x Coca Cola",
    "notes": "Extra cheese please",
    "status": "with courier",
    "created_at": "2024-01-05T10:30:00.000000Z",
    "updated_at": "2024-01-05T11:00:00.000000Z"
  }
}
```

**Error Response (422 Unprocessable Entity):**
```json
{
  "message": "The selected status is invalid.",
  "errors": {
    "status": [
      "The selected status is invalid."
    ]
  }
}
```

---

## Review Endpoints

### 15. Get Product Reviews

**Endpoint:** `GET /api/products/{product_id}/reviews`

**Authentication:** Not required

**Request Headers:**
```json
{
  "Accept": "application/json"
}
```

**Example Request:**
```
GET /api/products/1/reviews
```

**Success Response (200 OK):**
```json
{
  "status": "success",
  "count": 3,
  "data": [
    {
      "id": 1,
      "user_id": 2,
      "product_id": 1,
      "rating": 5,
      "comment": "Amazing pizza! Best I've ever had.",
      "created_at": "2024-01-02T00:00:00.000000Z",
      "updated_at": "2024-01-02T00:00:00.000000Z",
      "user": {
        "id": 2,
        "name": "Alice Johnson",
        "image": "profiles/alice.jpg",
        "image_url": "http://localhost:8000/storage/profiles/alice.jpg"
      }
    },
    {
      "id": 2,
      "user_id": 3,
      "product_id": 1,
      "rating": 4,
      "comment": "Very good, but a bit expensive.",
      "created_at": "2024-01-03T00:00:00.000000Z",
      "updated_at": "2024-01-03T00:00:00.000000Z",
      "user": {
        "id": 3,
        "name": "Bob Smith",
        "image": null,
        "image_url": null
      }
    },
    {
      "id": 3,
      "user_id": 4,
      "product_id": 1,
      "rating": 5,
      "comment": "Excellent quality and fast delivery!",
      "created_at": "2024-01-04T00:00:00.000000Z",
      "updated_at": "2024-01-04T00:00:00.000000Z",
      "user": {
        "id": 4,
        "name": "Carol White",
        "image": "profiles/carol.jpg",
        "image_url": "http://localhost:8000/storage/profiles/carol.jpg"
      }
    }
  ]
}
```

---

### 16. Create Product Review

**Endpoint:** `POST /api/products/{product}/reviews`

**Authentication:** Required (Bearer Token)

**Request Headers:**
```json
{
  "Authorization": "Bearer YOUR_ACCESS_TOKEN",
  "Content-Type": "application/json",
  "Accept": "application/json"
}
```

**Request Body:**
```json
{
  "rating": 5,
  "comment": "Absolutely delicious! Highly recommend."
}
```

**Validation Rules:**
- `rating`: required, integer, min 1, max 5
- `comment`: optional, string, max 1000 characters

**Success Response (201 Created):**
```json
{
  "status": "success",
  "message": "Thank you! Your feedback has been published securely.",
  "data": {
    "id": 4,
    "user_id": 1,
    "product_id": 1,
    "rating": 5,
    "comment": "Absolutely delicious! Highly recommend.",
    "created_at": "2024-01-06T15:30:00.000000Z",
    "updated_at": "2024-01-06T15:30:00.000000Z"
  }
}
```

**Error Response (422 Unprocessable Entity - Duplicate Review):**
```json
{
  "status": "error",
  "message": "You have already submitted a review score for this item!"
}
```

**Error Response (422 Unprocessable Entity - Validation Error):**
```json
{
  "message": "The rating field is required.",
  "errors": {
    "rating": [
      "The rating field is required."
    ]
  }
}
```

---

## Error Responses

### Common HTTP Status Codes

- **200 OK**: Request successful
- **201 Created**: Resource created successfully
- **401 Unauthorized**: Authentication required or invalid token
- **404 Not Found**: Resource not found
- **422 Unprocessable Entity**: Validation error
- **500 Internal Server Error**: Server error

### Standard Error Response Format

```json
{
  "status": "error",
  "message": "Error description here"
}
```

### Validation Error Response Format

```json
{
  "message": "The given data was invalid.",
  "errors": {
    "field_name": [
      "Error message for this field"
    ]
  }
}
```

---

## Authentication

Most endpoints require authentication using Laravel Sanctum Bearer tokens.

### How to Authenticate:

1. **Register or Login** to get an access token
2. **Include the token** in the Authorization header for protected endpoints:

```
Authorization: Bearer YOUR_ACCESS_TOKEN
```

### Example with cURL:

```bash
curl -X GET http://localhost:8000/api/user \
  -H "Authorization: Bearer 1|abcdefghijklmnopqrstuvwxyz" \
  -H "Accept: application/json"
```

### Example with JavaScript (Axios):

```javascript
axios.get('/api/user', {
  headers: {
    'Authorization': `Bearer ${accessToken}`,
    'Accept': 'application/json'
  }
})
.then(response => console.log(response.data))
.catch(error => console.error(error.response.data));
```

---

## Rate Limiting

The API may implement rate limiting to prevent abuse. If you exceed the rate limit, you'll receive a `429 Too Many Requests` response.

---

## CORS Configuration

The API supports Cross-Origin Resource Sharing (CORS) for frontend applications. Make sure your frontend domain is configured in the CORS settings.

---

## Testing with Postman

### Import Collection Steps:

1. Create a new collection in Postman
2. Add environment variables:
   - `base_url`: `http://localhost:8000/api`
   - `access_token`: Your bearer token after login
3. Use `{{base_url}}` and `{{access_token}}` in your requests

### Example Postman Request:

**URL:** `{{base_url}}/user`  
**Method:** GET  
**Headers:**
- `Authorization`: `Bearer {{access_token}}`
- `Accept`: `application/json`

---

## Support

For issues, questions, or feature requests, please contact the development team or create an issue in the project repository.

---

## Changelog

### Version 1.0.0 (Current)
- Initial API release
- Authentication endpoints
- User profile management
- Product catalog
- Order management
- Review system

---

**Last Updated:** January 2024  
**API Version:** 1.0.0
