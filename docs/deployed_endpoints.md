
## Deployed Endpoints

### Start the server

```bash
php -S localhost:8000
```

### Welcome

```bash
curl https://currenclever-api.fly.dev/api
```

### Sign up

```bash
curl -X POST https://currenclever-api.fly.dev/api/signup \
  -H "Content-Type: application/json" \
  -d '{
    "name": "John Doe",
    "email": "user@example.com",
    "password": "yourpassword"
  }'
```

### Login

```bash
curl -X POST https://currenclever-api.fly.dev/api/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "user@example.com",
    "password": "yourpassword"
  }'
```

### Get User Profile

```bash
curl -X POST https://currenclever-api.fly.dev/api/user \
  -H "Content-Type: application/json" \
  -d '{
    "email": "user@example.com"
  }'
```

### Get User Expenses

```bash
curl -X POST https://currenclever-api.fly.dev/api/expenses \
  -H "Content-Type: application/json" \
  -d '{
    "email": "user@example.com"
  }'
```

### Add Expense

```bash
curl -X POST https://currenclever-api.fly.dev/api/expenses \
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
curl -X POST https://currenclever-api.fly.dev/api/expenses \
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
curl -X POST https://currenclever-api.fly.dev/api/income \
  -H "Content-Type: application/json" \
  -d '{
    "email": "user@example.com"
  }'
```

### Create Income

```bash
curl -X POST https://currenclever-api.fly.dev/api/income \
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
curl -X POST https://currenclever-api.fly.dev/api/income \
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