# CurrenClever Backend

## Setup

Create a `.env` file in the root directory with your database credentials:

## Env

```env
DB_HOST=localhost
DB_NAME=currenclever
DB_USER=root
DB_PASS=
DB_CHARSET=utf8mb4
```

## Migration

```bash
php migrate.php
```

## API Endpoints

### Start the server

```bash
php -S localhost:8000
```

### Welcome

```bash
curl http://localhost:8000/api
```

### Sign up

```bash
curl -X POST http://localhost:8000/api/signup \
  -H "Content-Type: application/json" \
  -d '{
    "name": "John Doe",
    "email": "user@example.com",
    "password": "yourpassword"
  }'
```

### Login

```bash
curl -X POST http://localhost:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "user@example.com",
    "password": "yourpassword"
  }'
```

### Get User Profile

```bash
curl -X POST http://localhost:8000/api/user \
  -H "Content-Type: application/json" \
  -d '{
    "email": "user@example.com"
  }'
```

### Get User Expenses

```bash
curl -X POST http://localhost:8000/api/expenses \
  -H "Content-Type: application/json" \
  -d '{
    "email": "user@example.com"
  }'
```

### Add Expense

```bash
curl -X POST http://localhost:8000/api/expenses \
  -H "Content-Type: application/json" \
  -d '{
    "email": "user@example.com",
    "amount": 100.00,
    "currency": "USD",
    "date": "2024-03-15",
    "category": "Food",
    "note": "Lunch"
  }'
```

### Update Expense

```bash
curl -X POST http://localhost:8000/api/expenses \
  -H "Content-Type: application/json" \
  -d '{
    "id": 1,
    "email": "user@example.com",
    "amount": 150.00,
    "currency": "USD",
    "date": "2024-03-15",
    "category": "Food",
    "note": "Dinner"
  }'
```

### Get Income

```bash
curl -X POST http://localhost:8000/api/income \
  -H "Content-Type: application/json" \
  -d '{
    "email": "user@example.com"
  }'
```

### Create Income

```bash
curl -X POST http://localhost:8000/api/income \
  -H "Content-Type: application/json" \
  -d '{
    "email": "user@example.com",
    "amount": 5000.00,
    "currency": "USD",
    "date": "2024-03-15",
    "note": "Monthly salary"
  }'
```

### Update Income

```bash
curl -X POST http://localhost:8000/api/income \
  -H "Content-Type: application/json" \
  -d '{
    "id": 1,
    "email": "user@example.com",
    "amount": 5500.00,
    "currency": "USD",
    "date": "2024-03-15",
    "note": "Monthly salary with bonus"
  }'
```