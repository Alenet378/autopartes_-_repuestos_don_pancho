# AutoPartes y Repuestos Don Pancho

## Descripción del proyecto

Sistema web para la gestión y comercialización de autopartes y repuestos automotrices.

El proyecto permite consultar un catálogo de productos, visualizar información de sucursales, configurar kits de mantenimiento y gestionar procesos de facturación.

Además, incorpora un panel administrativo para el control del inventario y la gestión de productos mediante operaciones CRUD.

## Tecnologías utilizadas

- **Backend:** PHP.
- **Base de datos:** MySQL.
- **Conexión a base de datos:** PDO.
- **Frontend:** HTML5, CSS3, JavaScript y Bootstrap.
- **Servidor local:** Apache mediante XAMPP.

## Requisitos

Para ejecutar el proyecto se necesita:

- XAMPP instalado.
- PHP 8.0 o superior.
- MySQL o MariaDB.
- Navegador web actualizado.
- Extensión PDO para MySQL habilitada.
- Extensión Fileinfo habilitada para la validación de fotografías.

## Instalación y configuración

### 1. Descargar el proyecto

Clonar el repositorio:

```bash
git clone URL_DEL_REPOSITORIO
```

También se puede descargar el proyecto directamente desde GitHub.

### 2. Ubicar el proyecto

Copiar la carpeta del proyecto dentro del directorio `htdocs` de XAMPP.

Ejemplo:

```text
C:\xampp\htdocs\autopartes
```

### 3. Iniciar los servicios

Abrir el panel de control de XAMPP e iniciar:

- Apache.
- MySQL.

### 4. Importar la base de datos

1. Abrir phpMyAdmin desde `http://localhost/phpmyadmin`.
2. Crear una base de datos llamada `autopartes`.
3. Seleccionar la base de datos creada.
4. Entrar en la opción **Importar**.
5. Seleccionar el archivo `Base de Datos/base_de_datos.sql`.
6.Insertar los datos con el archivo `Base de Datos/datos_insert.sql`.
7. Ejecutar la importación.

### 5. Configurar la conexión

Abrir el archivo:

```text
include/conexion.php
```

Configurar los parámetros de conexión según el entorno local:

- Servidor: `localhost`.
- Base de datos: `alejandro`.
- Usuario: usuario configurado en MySQL.
- Contraseña: contraseña configurada en MySQL.

### 6. Ejecutar el sistema

Abrir el navegador y acceder a:

```text
http://localhost/autopartes/
```

## Funcionalidades principales

### Catálogo de productos
- Visualización de productos disponibles.
- Organización por categorías.
- Información de precios y existencias.
- Fotografías de los productos.

### Gestión de inventario
- Registro de nuevos productos.
- Edición de productos existentes.
- Eliminación de productos.
- Visualización del inventario mediante una tabla administrativa.

### Gestión de usuarios
- Inicio de sesión.
- Identificación de roles.
- Acceso al panel de administración según el rol.
- Cierre de sesión.

### Facturación
- Registro de información del cliente.
- Selección de productos y cantidades.
- Aplicación de descuentos.
- Cálculo del ISV.
- Cálculo de costos de envío.
- Generación de facturas.

### Seguridad
- Contraseñas almacenadas mediante hash.
- Validación de credenciales.
- Protección de rutas administrativas.
- Validación de fotografías mediante extensión y tipo MIME.
- Límite de tamaño para fotografías de 4 MB.
- Generación de nombres únicos para archivos cargados.

## Credenciales de evaluación

Las siguientes cuentas están destinadas a la evaluación del sistema:

| Rol | Correo electrónico | Contraseña |
|---|---|---|
| Administrador | alejo@gmail.com | 12345 |
| Bodega | frixon@gmail.com | 12345 |
| Usuario | paco@gmail.com | 12345 |



