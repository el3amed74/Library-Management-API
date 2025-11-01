# 📚 Library Management System API

A comprehensive RESTful API for managing library operations built with Laravel 12. This system handles book inventory, member management, borrowing transactions, and provides real-time statistics for efficient library administration.

## 🎯 Features

### Authentication & Authorization
- User registration and login
- Laravel Sanctum token-based authentication
- Secure password hashing
- Protected API endpoints

### Book Management
- Full CRUD operations for books
- Advanced search functionality (by title, ISBN, author name)
- Genre filtering
- Book availability tracking
- Cover image support
- Automatic copy management (total vs available copies)

### Author Management
- Complete author profile management
- Author biography and nationality tracking
- Relationship with books

### Member Management
- Member registration and profile management
- Membership date tracking
- Member status management
- Active borrowing tracking

### Borrowing Management
- Book borrowing transactions
- Due date tracking
- Automatic overdue detection and status updates
- Book return processing
- Borrowing history with filtering options
- Search by member and status

### Statistics Dashboard
- Total books count
- Total authors count
- Total members count
- Currently borrowed books
- Overdue borrowings count

## 🛠️ Tech Stack

- **Framework**: Laravel 12
- **PHP**: 8.2+
- **Authentication**: Laravel Sanctum
- **Database**: MySQL 
- **Validation**: Form Request classes
- **API Resources**: Laravel API Resources for consistent JSON responses

## 📋 Prerequisites

- PHP >= 8.2
- Composer
- MySQL

## 🚀 Installation

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd lib-mgt-api
   ```

2. **Install dependencies**
   ```bash
   composer install
   ```

3. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Configure database**
   - Update `.env` file with your database credentials
   - For SQLite, ensure `database/database.sqlite` exists

5. **Run migrations**
   ```bash
   php artisan migrate
   ```

6. **Start the server**
   ```bash
   php artisan serve
   ```

The API will be available at `http://localhost:8000`

## 📡 API Endpoints

### Authentication Endpoints

#### Register
```
POST /api/register
Content-Type: application/json

{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password123",
    "password_confirmation": "password123"
}
```

#### Login
```
POST /api/login
Content-Type: application/json

{
    "email": "john@example.com",
    "password": "password123"
}
```

#### Get Authenticated User
```
GET /api/user
Authorization: Bearer {token}
```

#### Logout
```
POST /api/logout
Authorization: Bearer {token}
```

### Books Endpoints

All book endpoints require authentication.

- `GET /api/books` - List all books (supports `?search=` and `?genre=` query parameters)
- `POST /api/books` - Create a new book
- `GET /api/books/{id}` - Get book details
- `PUT /api/books/{id}` - Update book
- `DELETE /api/books/{id}` - Delete book

**Book Search Example:**
```
GET /api/books?search=harry&genre=fiction
```

### Authors Endpoints

All author endpoints require authentication.

- `GET /api/authers` - List all authors
- `POST /api/authers` - Create a new author
- `GET /api/authers/{id}` - Get author details
- `PUT /api/authers/{id}` - Update author
- `DELETE /api/authers/{id}` - Delete author

### Members Endpoints

All member endpoints require authentication.

- `GET /api/members` - List all members
- `POST /api/members` - Create a new member
- `GET /api/members/{id}` - Get member details
- `PUT /api/members/{id}` - Update member
- `DELETE /api/members/{id}` - Delete member

### Borrowing Endpoints

All borrowing endpoints require authentication.

- `GET /api/borrowings` - List all borrowings (supports `?status=` and `?member_id=` query parameters)
- `POST /api/borrowings` - Create a new borrowing transaction
- `GET /api/borrowings/{id}` - Get borrowing details
- `POST /api/borrowings/{id}/return` - Return a borrowed book
- `GET /api/borrowings/overdue/list` - Get all overdue borrowings

**Borrowing Creation Example:**
```
POST /api/borrowings
Content-Type: application/json

{
    "book_id": 1,
    "member_id": 1,
    "borrowed_date": "2025-01-15",
    "due_date": "2025-01-29"
}
```

### Statistics Endpoint

- `GET /api/statistics` - Get library statistics

**Response:**
```json
{
    "total_books": 150,
    "total_authors": 45,
    "total_members": 120,
    "book_borrowed": 35,
    "overdue_borrowings": 5
}
```

## 🔒 Authentication

All endpoints (except register and login) require Bearer token authentication. Include the token in the Authorization header:

```
Authorization: Bearer {your_token_here}
```

## 📊 Data Models

### Book
- Title, ISBN (unique), Description
- Author relationship
- Genre, Published date
- Total copies, Available copies
- Price, Cover image
- Status (available/unavailable)

### Author
- Name, Biography, Nationality
- Has many books

### Member
- Name, Email, Address
- Membership date
- Status
- Has many borrowings

### Borrowing
- Book relationship
- Member relationship
- Borrowed date, Due date, Returned date
- Status (borrowed/returned/overdue)


---

**Note**: This is a RESTful API. To use it with a frontend application, you'll need to make HTTP requests from your frontend framework (React, Vue, Angular, etc.) to these endpoints.
