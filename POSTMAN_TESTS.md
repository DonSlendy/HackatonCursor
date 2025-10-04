# 🚀 Guía de Pruebas en Postman - API Platillos

## 📋 Configuración Inicial

### Variables de Entorno en Postman
Crea las siguientes variables en tu colección:

- `base_url`: `http://localhost:8000/api`
- `platillo_id`: `1` (se actualizará automáticamente)

---

## 🍽️ PRUEBAS PARA PLATILLOS

### 1. **GET - Listar Todos los Platillos**
```
Method: GET
URL: {{base_url}}/platillos
Headers: 
  Content-Type: application/json
```

**Respuesta Esperada:**
```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "nombre": "Pizza Margherita",
            "calorias": "350.50",
            "indicaciones": "Horno a 200°C por 15 minutos",
            "created_at": "2024-01-15 10:30:00",
            "updated_at": "2024-01-15 10:30:00"
        }
    ]
}
```

---

### 2. **POST - Crear Nuevo Platillo**
```
Method: POST
URL: {{base_url}}/platillos
Headers: 
  Content-Type: application/json

Body (raw JSON):
{
    "nombre": "Pizza Margherita",
    "calorias": 350.50,
    "indicaciones": "Horno a 200°C por 15 minutos"
}
```

**Respuesta Esperada (201 Created):**
```json
{
    "success": true,
    "message": "Platillo creado exitosamente",
    "data": {
        "id": 1,
        "nombre": "Pizza Margherita",
        "calorias": "350.50",
        "indicaciones": "Horno a 200°C por 15 minutos",
        "created_at": "2024-01-15 10:30:00",
        "updated_at": "2024-01-15 10:30:00"
    }
}
```

**⚠️ Prueba de Validación (Error 422):**
```json
{
    "nombre": "",
    "calorias": -10,
    "indicaciones": ""
}
```

---

### 3. **GET - Mostrar Platillo Específico**
```
Method: GET
URL: {{base_url}}/platillos/{{platillo_id}}
Headers: 
  Content-Type: application/json
```

**Respuesta Esperada:**
```json
{
    "success": true,
    "data": {
        "id": 1,
        "nombre": "Pizza Margherita",
        "calorias": "350.50",
        "indicaciones": "Horno a 200°C por 15 minutos",
        "created_at": "2024-01-15 10:30:00",
        "updated_at": "2024-01-15 10:30:00"
    }
}
```

---

### 4. **PUT - Actualizar Platillo**
```
Method: PUT
URL: {{base_url}}/platillos/{{platillo_id}}
Headers: 
  Content-Type: application/json

Body (raw JSON):
{
    "nombre": "Pizza Margherita Especial",
    "calorias": 380.75,
    "indicaciones": "Horno a 220°C por 12 minutos"
}
```

**Respuesta Esperada:**
```json
{
    "success": true,
    "message": "Platillo actualizado exitosamente",
    "data": {
        "id": 1,
        "nombre": "Pizza Margherita Especial",
        "calorias": "380.75",
        "indicaciones": "Horno a 220°C por 12 minutos",
        "created_at": "2024-01-15 10:30:00",
        "updated_at": "2024-01-15 11:45:00"
    }
}
```

---

### 5. **PATCH - Actualización Parcial**
```
Method: PATCH
URL: {{base_url}}/platillos/{{platillo_id}}
Headers: 
  Content-Type: application/json

Body (raw JSON):
{
    "calorias": 400.00
}
```

---

### 6. **DELETE - Eliminar Platillo**
```
Method: DELETE
URL: {{base_url}}/platillos/{{platillo_id}}
Headers: 
  Content-Type: application/json
```

**Respuesta Esperada (200 OK):**
```json
{
    "success": true,
    "message": "Platillo eliminado exitosamente"
}
```

---

## 🧪 PRUEBAS DE VALIDACIÓN

### Validación de Campos Requeridos
```json
{
    "nombre": "",
    "calorias": "",
    "indicaciones": ""
}
```

### Validación de Tipos de Datos
```json
{
    "nombre": "Test",
    "calorias": "texto_invalido",
    "indicaciones": "Test"
}
```

### Validación de Calorías Negativas
```json
{
    "nombre": "Test",
    "calorias": -100,
    "indicaciones": "Test"
}
```

---

## 📊 CASOS DE PRUEBA ADICIONALES

### 1. **Prueba de Límites de Caracteres**
```json
{
    "nombre": "A".repeat(256),
    "calorias": 100,
    "indicaciones": "A".repeat(256)
}
```

### 2. **Prueba de Números Decimales**
```json
{
    "nombre": "Platillo Decimal",
    "calorias": 123.456789,
    "indicaciones": "Prueba decimal"
}
```

### 3. **Prueba de Caracteres Especiales**
```json
{
    "nombre": "Platillo con Ñ y Áccéntos",
    "calorias": 250.50,
    "indicaciones": "Instrucciones con símbolos: @#$%^&*()"
}
```

---

## 🔧 CONFIGURACIÓN DE TESTS AUTOMÁTICOS EN POSTMAN

### Test Script para POST (Crear Platillo)
```javascript
pm.test("Status code is 201", function () {
    pm.response.to.have.status(201);
});

pm.test("Response has success true", function () {
    const jsonData = pm.response.json();
    pm.expect(jsonData.success).to.be.true;
});

pm.test("Response has platillo data", function () {
    const jsonData = pm.response.json();
    pm.expect(jsonData.data).to.have.property('id');
    pm.expect(jsonData.data).to.have.property('nombre');
    pm.expect(jsonData.data).to.have.property('calorias');
    pm.expect(jsonData.data).to.have.property('indicaciones');
});

// Guardar ID para siguientes pruebas
if (pm.response.json().data.id) {
    pm.collectionVariables.set("platillo_id", pm.response.json().data.id);
}
```

### Test Script para GET (Listar Platillos)
```javascript
pm.test("Status code is 200", function () {
    pm.response.to.have.status(200);
});

pm.test("Response has success true", function () {
    const jsonData = pm.response.json();
    pm.expect(jsonData.success).to.be.true;
});

pm.test("Response has data array", function () {
    const jsonData = pm.response.json();
    pm.expect(jsonData.data).to.be.an('array');
});
```

---

## 🚀 INSTRUCCIONES PARA EJECUTAR

1. **Inicia tu servidor Laravel:**
   ```bash
   php artisan serve
   ```

2. **Ejecuta las migraciones:**
   ```bash
   php artisan migrate
   ```

3. **Importa la colección en Postman**

4. **Ejecuta las pruebas en este orden:**
   - POST (Crear platillo)
   - GET (Listar platillos)
   - GET (Mostrar platillo específico)
   - PUT (Actualizar platillo)
   - DELETE (Eliminar platillo)

5. **Verifica los códigos de estado HTTP:**
   - 200: OK
   - 201: Created
   - 422: Validation Error
   - 404: Not Found
   - 500: Server Error

---

## 📝 NOTAS IMPORTANTES

- Asegúrate de que tu servidor Laravel esté ejecutándose en `http://localhost:8000`
- Las variables de entorno se actualizan automáticamente
- Prueba tanto casos exitosos como casos de error
- Verifica que las validaciones funcionen correctamente
- Los timestamps se formatean automáticamente en el resource
