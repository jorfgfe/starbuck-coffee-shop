# Starbuck Coffee Shop

Test app for 25f.

## How to instal??

### 1. Instalar dependencias
```bash
composer install
```

### 2. Generate key.
```bash
# Generar la clave de la aplicación
php artisan key:generate
```

### 3. Database configuration.
The project is using SQLite, if you want to change it just go to the file:  `.env`:
```env
DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite
```

### 4. Run migrations
```bash
php artisan migrate

```

### 5. Start the server.
```bash
php artisan serve
```

The app would be running on `http://localhost:8000`

## 📚 API Endpoints

### Products
```http
GET    /api/v1/products        
GET    /api/v1/products/{id}    
POST   /api/v1/products         
PUT    /api/v1/products/{id} 
PATCH  /api/v1/products/{id}    
DELETE /api/v1/products/{id}    
```

### Categories
```http
GET    /api/v1/categories         
GET    /api/v1/categories/{id}    
POST   /api/v1/categories         
PUT    /api/v1/categories/{id}    
PATCH  /api/v1/categories/{id}    
DELETE /api/v1/categories/{id}   
```

### Extras
```http
GET    /api/v1/extras         
GET    /api/v1/extras/{id}    
POST   /api/v1/extras          
PUT    /api/v1/extras/{id}    
PATCH  /api/v1/extras/{id}   
DELETE /api/v1/extras/{id}    
```

### Orders
```http
POST   /api/v1/orders
```

## 📝 Ejemplos de Uso

### Make a Category
```bash
curl -X POST http://localhost:8000/api/v1/categories \
  -H "Content-Type: application/json" \
  -d '{"name": "Bebidas"}'
```

### Make a Product
```bash
curl -X POST http://localhost:8000/api/v1/products \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Coca Cola",
    "price": 2.50,
    "stock": 100,
    "category_id": 1
  }'
```

### Make a Extra
```bash
curl -X POST http://localhost:8000/api/v1/extras \
  -H "Content-Type: application/json" \
  -d '{"name": "Extra Queso", "price": 0.50}'
```

### Make a Order
```bash
curl -X POST http://localhost:8000/api/v1/orders \
  -H "Content-Type: application/json" \
  -d '{
    "order": [
      {
        "productId": 1,
        "quantity": 2,
        "extra": [1, 2]
      },
      {
        "productId": 2,
        "quantity": 1
      }
    ],
    "payment": 50.00
  }'
```

## 🧪 Run Tests

### To run all tests
```bash
php artisan test
```
