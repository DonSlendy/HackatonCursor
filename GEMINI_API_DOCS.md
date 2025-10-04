# Gemini AI API - Documentación

## Configuración

### 1. Variables de entorno
Agrega tu clave API de Gemini al archivo `.env`:

```env
GEMINI_API_KEY=tu_clave_api_aqui
GEMINI_API_URL=https://generativelanguage.googleapis.com/v1beta
GEMINI_MODEL=gemini-pro
```

### 2. Instalar dependencias
```bash
composer install
```

## Endpoints disponibles

### Base URL
```
http://localhost:8000/api/gemini
```

### 1. Verificar estado del servicio
```http
GET /api/gemini/status
```

**Respuesta:**
```json
{
    "success": true,
    "data": {
        "configured": true,
        "service": "Gemini AI",
        "status": "ready"
    }
}
```

### 2. Generar contenido básico
```http
POST /api/gemini/generate
Content-Type: application/json

{
    "prompt": "Explica qué es la inteligencia artificial",
    "temperature": 0.7,
    "maxOutputTokens": 1024
}
```

**Respuesta:**
```json
{
    "success": true,
    "data": {
        "content": "La inteligencia artificial (IA) es...",
        "usage": {
            "promptTokenCount": 10,
            "candidatesTokenCount": 150,
            "totalTokenCount": 160
        }
    }
}
```

### 3. Generar contenido con contexto
```http
POST /api/gemini/generate-with-context
Content-Type: application/json

{
    "prompt": "¿Cuál es la mejor práctica?",
    "context": "Estamos desarrollando una aplicación Laravel con API REST",
    "temperature": 0.5
}
```

### 4. Generar código
```http
POST /api/gemini/generate-code
Content-Type: application/json

{
    "description": "Crear una función que valide un email",
    "language": "php",
    "temperature": 0.3
}
```

### 5. Analizar texto
```http
POST /api/gemini/analyze
Content-Type: application/json

{
    "text": "Este producto es increíble, me encanta usarlo todos los días",
    "analysis_type": "sentiment"
}
```

**Tipos de análisis disponibles:**
- `general`: Análisis general del texto
- `sentiment`: Análisis de sentimientos
- `keywords`: Extracción de palabras clave
- `summary`: Resumen del texto

## Parámetros opcionales

### Opciones de generación
- `temperature` (0-2): Controla la creatividad (0 = más determinístico, 2 = más creativo)
- `maxOutputTokens` (1-8192): Máximo número de tokens en la respuesta
- `topK` (1-100): Limita las opciones de vocabulario
- `topP` (0-1): Controla la diversidad de la respuesta

## Ejemplos de uso con cURL

### Verificar estado
```bash
curl -X GET http://localhost:8000/api/gemini/status
```

### Generar contenido
```bash
curl -X POST http://localhost:8000/api/gemini/generate \
  -H "Content-Type: application/json" \
  -d '{
    "prompt": "Escribe un poema sobre la programación",
    "temperature": 0.8
  }'
```

### Generar código PHP
```bash
curl -X POST http://localhost:8000/api/gemini/generate-code \
  -H "Content-Type: application/json" \
  -d '{
    "description": "Función para calcular el factorial de un número",
    "language": "php"
  }'
```

## Manejo de errores

### Error de configuración
```json
{
    "success": false,
    "message": "Servicio de Gemini no configurado correctamente"
}
```

### Error de validación
```json
{
    "success": false,
    "message": "Datos de entrada inválidos",
    "errors": {
        "prompt": ["El campo prompt es obligatorio."]
    }
}
```

### Error de API
```json
{
    "success": false,
    "message": "Error en la API de Gemini",
    "status_code": 400,
    "response": "Invalid API key"
}
```

## Iniciar el servidor

```bash
php artisan serve
```

El servidor estará disponible en `http://localhost:8000`
