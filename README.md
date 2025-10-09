# Mini app demo: HTML/CSS/JS + PHP + SQL

Esta demo cumple con los puntos solicitados:

- HTML/PHP: `index.php` con maquetado y UI
- CSS: `assets/css/styles.css`
- JavaScript: `assets/js/app.js` (AJAX con fetch)
- PHP: API en `api/tasks.php` y conexión en `api/config.php`
- SQL: `sql/schema.sql` para crear la BD

Además se agregó un formulario de productos:
- HTML/PHP: `product.php`
- JavaScript: `assets/js/product.js`
- Catálogos API: `api/catalog.php`
- Productos API: `api/products.php`

## Requisitos
- PHP 7.4+ con extensión PDO MySQL habilitada
- MySQL/MariaDB local o remoto

## Instalación
1. Importa el esquema SQL:
   - Abre tu cliente MySQL y ejecuta `sql/schema.sql`.
2. Configura la conexión en `api/config.php`:
   - Por defecto usa `DB_HOST=127.0.0.1`, `DB_NAME=prueba_desis`, `DB_USER=root`, `DB_PASS=''`.
   - Puedes usar variables de entorno `DB_HOST`, `DB_NAME`, `DB_USER`, `DB_PASS`.

## Ejecutar en local (servidor PHP embebido)
En Windows PowerShell, desde la carpeta del proyecto:

```powershell
php -S localhost:8000 -t .
```

Luego abre: http://localhost:8000/

## Endpoints
- `POST api/tasks.php` con JSON `{ action: 'list', q?: string }`
- `POST api/tasks.php` con JSON `{ action: 'create', title: string, description?: string }`
- `POST api/tasks.php` con JSON `{ action: 'delete', id: number }`

### Catálogos y Productos
- `POST api/catalog.php` `{ action: 'warehouses' }` → lista de bodegas
- `POST api/catalog.php` `{ action: 'branches', warehouse_id: number }` → sucursales por bodega
- `POST api/catalog.php` `{ action: 'currencies' }` → monedas
- `POST api/products.php` `{ action: 'check_code', code: string }` → unicidad de código
- `POST api/products.php` `{ action: 'create', ... }` → crear producto

## Notas
- Este proyecto es un esqueleto mínimo y expandible.
- Maneja CORS simple; si lo usas desde el mismo origen, no necesitas cambios.
- Validación básica del lado del servidor para crear y eliminar.
 
## Formulario de Productos (cómo probar)
1. Importa nuevamente `sql/schema.sql` para crear catálogos (bodegas, sucursales, monedas) y tablas de productos.
2. Abre http://localhost:8000/product.php
3. Completa los campos; las validaciones se hacen con JavaScript (sin `required`).
4. El botón "Guardar Producto" enviará por AJAX y si todo está correcto verás un alert de éxito.
