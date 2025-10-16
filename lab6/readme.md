# Pruebas de la API REST Biblioteca (curl)

## 1. Listar todos los libros con autores y editorial curl o Invoke-RestMethod
```bash
curl -X GET http://localhost/lab6/public/api/books
```

## 2. Buscar libros por título, autor o editorial curl o Invoke-RestMethod
```bash
curl -X GET "http://localhost/lab6/public/api/books?q=Harry"
```

## 3. Prestar un libro (crear préstamo) curl o Invoke-RestMethod
```bash
curl -X POST http://localhost/lab6/public/api/loans \
  -H "Content-Type: application/json" \
  -d '{"member_id":1, "book_id":2}'
```

## 4. Devolver un libro (actualizar returned_at) curl o Invoke-RestMethod
```bash
curl -X PATCH http://localhost/lab6/public/api/loans/1
```

## 5. Crear un nuevo libro curl o Invoke-RestMethod
```bash
curl -X POST http://localhost/lab6/public/api/books \
  -H "Content-Type: application/json" \
  -d '{
  "isbn":"123-456-789",
    "title":"Nuevo Libro",
    "publisher_id":1,
    "publication_year":2025,
    "pages":100,
    "authors":[1,2]
}'
```
