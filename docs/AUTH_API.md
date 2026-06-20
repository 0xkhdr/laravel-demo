# Authentication API Documentation

## OpenAPI 3.0.0 Specification

```yaml
openapi: 3.0.0
info:
  title: Authentication API
  description: User authentication and authorization API using Laravel Sanctum
  version: 1.0.0
  contact:
    name: API Support
    email: support@example.com

servers:
  - url: http://localhost:8000
    description: Development server
  - url: https://api.example.com
    description: Production server

paths:
  /api/auth/register:
    post:
      summary: Register new user
      description: Create a new user account with email and password
      operationId: registerUser
      tags:
        - Authentication
      requestBody:
        required: true
        content:
          application/json:
            schema:
              type: object
              required:
                - name
                - email
                - password
              properties:
                name:
                  type: string
                  description: User's full name
                  example: John Doe
                email:
                  type: string
                  format: email
                  description: User's email address
                  example: john@example.com
                password:
                  type: string
                  format: password
                  description: User's password (min 8 characters)
                  example: SecurePassword123
      responses:
        '201':
          description: User successfully registered
          content:
            application/json:
              schema:
                type: object
                properties:
                  message:
                    type: string
                    example: User registered successfully
                  user:
                    type: object
                    properties:
                      id:
                        type: integer
                        example: 1
                      name:
                        type: string
                        example: John Doe
                      email:
                        type: string
                        example: john@example.com
        '422':
          description: Validation error
          content:
            application/json:
              schema:
                type: object
                properties:
                  message:
                    type: string
                    example: The given data was invalid
                  errors:
                    type: object
                    properties:
                      email:
                        type: array
                        items:
                          type: string
                        example:
                          - The email has already been taken
                      password:
                        type: array
                        items:
                          type: string
                        example:
                          - The password must be at least 8 characters

  /api/auth/login:
    post:
      summary: Authenticate user and get token
      description: Login with email and password to receive a Sanctum authentication token
      operationId: loginUser
      tags:
        - Authentication
      requestBody:
        required: true
        content:
          application/json:
            schema:
              type: object
              required:
                - email
                - password
              properties:
                email:
                  type: string
                  format: email
                  description: User's email address
                  example: john@example.com
                password:
                  type: string
                  format: password
                  description: User's password
                  example: SecurePassword123
      responses:
        '200':
          description: User successfully authenticated
          content:
            application/json:
              schema:
                type: object
                properties:
                  message:
                    type: string
                    example: Login successful
                  token:
                    type: string
                    description: Sanctum API token for authenticated requests
                    example: 1|abcd1234efgh5678ijkl9012mnop3456qrst7890
                  user:
                    type: object
                    properties:
                      id:
                        type: integer
                        example: 1
                      name:
                        type: string
                        example: John Doe
                      email:
                        type: string
                        example: john@example.com
                      roles:
                        type: array
                        items:
                          type: object
                          properties:
                            id:
                              type: integer
                              example: 1
                            name:
                              type: string
                              example: admin
                        example:
                          - id: 1
                            name: admin
        '401':
          description: Invalid credentials
          content:
            application/json:
              schema:
                type: object
                properties:
                  message:
                    type: string
                    example: Invalid email or password

  /api/auth/profile:
    get:
      summary: Get authenticated user profile
      description: Retrieve the authenticated user's profile information
      operationId: getUserProfile
      tags:
        - Authentication
      security:
        - BearerToken: []
      responses:
        '200':
          description: User profile retrieved successfully
          content:
            application/json:
              schema:
                type: object
                properties:
                  id:
                    type: integer
                    example: 1
                  name:
                    type: string
                    example: John Doe
                  email:
                    type: string
                    example: john@example.com
                  roles:
                    type: array
                    items:
                      type: object
                      properties:
                        id:
                          type: integer
                          example: 1
                        name:
                          type: string
                          example: admin
                    example:
                      - id: 1
                        name: admin
        '401':
          description: Unauthorized - invalid or missing token
          content:
            application/json:
              schema:
                type: object
                properties:
                  message:
                    type: string
                    example: Unauthenticated

  /api/auth/logout:
    post:
      summary: Revoke all tokens and logout
      description: Logout the user by revoking all active Sanctum tokens
      operationId: logoutUser
      tags:
        - Authentication
      security:
        - BearerToken: []
      responses:
        '200':
          description: User successfully logged out
          content:
            application/json:
              schema:
                type: object
                properties:
                  message:
                    type: string
                    example: Logged out successfully
        '401':
          description: Unauthorized - invalid or missing token
          content:
            application/json:
              schema:
                type: object
                properties:
                  message:
                    type: string
                    example: Unauthenticated

components:
  securitySchemes:
    BearerToken:
      type: http
      scheme: bearer
      bearerFormat: Laravel Sanctum Token
      description: |
        Use the token returned from the login endpoint.
        Format: Authorization: Bearer <token>

  schemas:
    User:
      type: object
      properties:
        id:
          type: integer
        name:
          type: string
        email:
          type: string
        roles:
          type: array
          items:
            $ref: '#/components/schemas/Role'

    Role:
      type: object
      properties:
        id:
          type: integer
        name:
          type: string

    ValidationError:
      type: object
      properties:
        message:
          type: string
        errors:
          type: object

    UnauthorizedError:
      type: object
      properties:
        message:
          type: string

tags:
  - name: Authentication
    description: User authentication endpoints
```

## Overview

This API provides user authentication and authorization services using Laravel Sanctum for token-based authentication. All requests should be made to the API base URL with appropriate headers.

## Base URL

- **Development**: `http://localhost:8000`
- **Production**: `https://api.example.com`

## Authentication

This API uses **Bearer Token Authentication** (Laravel Sanctum) for protected endpoints.

### How to Authenticate

1. Call the login endpoint to receive a token
2. Include the token in all subsequent requests using the Authorization header:

```
Authorization: Bearer <token>
```

### Token Format

Tokens are returned in the following format:
```
1|abcd1234efgh5678ijkl9012mnop3456qrst7890
```

### Token Scope

Sanctum tokens are valid for API requests and can be revoked individually or all at once on logout.

## Error Handling

The API uses standard HTTP status codes and returns JSON error responses.

### HTTP Status Codes

- **200 OK**: Request successful
- **201 Created**: Resource created successfully
- **400 Bad Request**: Invalid request format
- **401 Unauthorized**: Missing or invalid authentication token
- **403 Forbidden**: Authenticated but not authorized for the resource
- **422 Unprocessable Entity**: Validation error with the submitted data
- **500 Internal Server Error**: Server error

### Error Response Format

#### Validation Error (422)

```json
{
  "message": "The given data was invalid",
  "errors": {
    "email": [
      "The email has already been taken"
    ],
    "password": [
      "The password must be at least 8 characters"
    ]
  }
}
```

#### Authentication Error (401)

```json
{
  "message": "Unauthenticated"
}
```

#### Generic Error

```json
{
  "message": "Error description"
}
```

## API Endpoints

### 1. Register New User

**Endpoint**: `POST /api/auth/register`

Register a new user account.

**Request Headers**:
```
Content-Type: application/json
```

**Request Body**:
```json
{
  "name": "John Doe",
  "email": "john@example.com",
  "password": "SecurePassword123"
}
```

**Success Response (201 Created)**:
```json
{
  "message": "User registered successfully",
  "user": {
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com"
  }
}
```

**Validation Error Response (422)**:
```json
{
  "message": "The given data was invalid",
  "errors": {
    "email": [
      "The email has already been taken"
    ],
    "password": [
      "The password must be at least 8 characters"
    ]
  }
}
```

**Validation Rules**:
- `name`: Required, string
- `email`: Required, valid email format, unique in database
- `password`: Required, minimum 8 characters

---

### 2. Login User

**Endpoint**: `POST /api/auth/login`

Authenticate a user and receive an API token.

**Request Headers**:
```
Content-Type: application/json
```

**Request Body**:
```json
{
  "email": "john@example.com",
  "password": "SecurePassword123"
}
```

**Success Response (200 OK)**:
```json
{
  "message": "Login successful",
  "token": "1|abcd1234efgh5678ijkl9012mnop3456qrst7890",
  "user": {
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com",
    "roles": [
      {
        "id": 1,
        "name": "admin"
      }
    ]
  }
}
```

**Error Response (401)**:
```json
{
  "message": "Invalid email or password"
}
```

**Validation Rules**:
- `email`: Required, valid email format
- `password`: Required

---

### 3. Get User Profile

**Endpoint**: `GET /api/auth/profile`

Retrieve the authenticated user's profile information and assigned roles.

**Request Headers**:
```
Authorization: Bearer <token>
Content-Type: application/json
```

**Success Response (200 OK)**:
```json
{
  "id": 1,
  "name": "John Doe",
  "email": "john@example.com",
  "roles": [
    {
      "id": 1,
      "name": "admin"
    }
  ]
}
```

**Error Response (401)**:
```json
{
  "message": "Unauthenticated"
}
```

**Requirements**:
- Valid Bearer token required
- Token must not be expired

---

### 4. Logout User

**Endpoint**: `POST /api/auth/logout`

Logout the user by revoking all active API tokens.

**Request Headers**:
```
Authorization: Bearer <token>
Content-Type: application/json
```

**Success Response (200 OK)**:
```json
{
  "message": "Logged out successfully"
}
```

**Error Response (401)**:
```json
{
  "message": "Unauthenticated"
}
```

**Requirements**:
- Valid Bearer token required
- All tokens for the user will be revoked after logout

---

## Complete Usage Example

### 1. Register a New User

```bash
curl -X POST http://localhost:8000/api/auth/register \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Jane Smith",
    "email": "jane@example.com",
    "password": "SecurePass123"
  }'
```

### 2. Login

```bash
curl -X POST http://localhost:8000/api/auth/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "jane@example.com",
    "password": "SecurePass123"
  }'
```

Response includes token:
```json
{
  "message": "Login successful",
  "token": "1|abcd1234efgh5678ijkl9012mnop3456qrst7890",
  "user": {
    "id": 2,
    "name": "Jane Smith",
    "email": "jane@example.com",
    "roles": []
  }
}
```

### 3. Get Profile (Authenticated)

```bash
curl -X GET http://localhost:8000/api/auth/profile \
  -H "Authorization: Bearer 1|abcd1234efgh5678ijkl9012mnop3456qrst7890" \
  -H "Content-Type: application/json"
```

### 4. Logout (Authenticated)

```bash
curl -X POST http://localhost:8000/api/auth/logout \
  -H "Authorization: Bearer 1|abcd1234efgh5678ijkl9012mnop3456qrst7890" \
  -H "Content-Type: application/json"
```

---

## Content Negotiation

All endpoints accept and return `application/json`.

**Request**: Include `Content-Type: application/json` header
**Response**: All responses are in JSON format

---

## Rate Limiting

Currently, no rate limiting is enforced. Future versions may implement rate limiting.

---

## Security Considerations

1. **Always use HTTPS** in production environments
2. **Keep tokens secure** - never expose them in URLs or logs
3. **Token expiration** - implement token rotation for long-lived sessions
4. **Password security** - use strong passwords (minimum 8 characters recommended)
5. **CORS** - ensure CORS policies are properly configured for your client domain

---

## API Version

Current API Version: **1.0.0**

The API follows semantic versioning. Breaking changes will increment the major version number and be clearly documented.

---

## Support

For API support and questions, contact the development team at support@example.com.
