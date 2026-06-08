# Sistema MVC con PHP - Tienda MVC

## Descripción

Sistema web desarrollado en PHP con arquitectura MVC que permite la gestión de productos a través de un panel de administración y un catálogo público para visitantes.

## Documentación Oficial

Puedes consultar la documentación completa de la API REST, instalación, y guía de uso del sistema (generada con Mintlify) en el siguiente enlace:

->**[https://reduardo.mintlify.app/introduction](https://reduardo.mintlify.app/introduction)**

## Tecnologías Utilizadas

- **PHP** (Orientado a Objetos)
- **MySQL** (Base de datos)
- **PDO** (Acceso a datos)
- **Bootstrap 5** (Interfaz de usuario)
- **Namespaces y Autoload** (Organización del código)
- **Transacciones** (Integridad de datos)

## Estructura del Proyecto

```
tienda_mvc/
├── config/
│   ├── Database.php        (Conexión a BD con PDO)
│   └── Autoload.php        (Autoload de clases)
├── controllers/
│   ├── AuthController.php  (Autenticación)
│   ├── ProductoController.php (CRUD de productos)
│   └── PublicController.php   (Catálogo público)
├── models/
│   ├── UsuarioModel.php    (Modelo de usuarios)
│   └── ProductoModel.php   (Modelo de productos)
├── views/
│   ├── layouts/
│   │   ├── header.php      (Plantilla superior)
│   │   └── footer.php      (Plantilla inferior)
│   ├── auth/
│   │   └── login.php       (Vista de login)
│   ├── productos/
│   │   ├── index.php       (Lista de productos admin)
│   │   ├── create.php      (Formulario de alta)
│   │   └── edit.php        (Formulario de edición)
│   └── public/
│       └── catalogo.php    (Catálogo público)
├── index.php               (Front Controller)
├── .htaccess               (Reescritura de URLs)
├── database.sql            (Script de base de datos)
└── README.md               (Este archivo)
```

## Instalación

### 1. Base de Datos

1. Abrir phpMyAdmin o la terminal de MySQL
2. Ejecutar el archivo `database.sql`
3. Esto creará la base de datos `tienda_mvc`, las tablas y un usuario administrador

### 2. Configuración

1. Copiar la carpeta `tienda_mvc` en la carpeta `htdocs` de XAMPP (o la carpeta correspondiente de tu servidor)
2. Verificar la configuración de la base de datos en `config/Database.php`:
   - Host: `localhost`
   - Base de datos: `tienda_mvc`
   - Usuario: `root`
   - Contraseña: `` (vacía por defecto en XAMPP)

### 3. Ejecución

1. Iniciar Apache y MySQL desde XAMPP
2. Acceder a `http://localhost/tienda_mvc/`

## Credenciales de Administrador

- **Usuario:** `admin`
- **Contraseña:** `admin123`

## Funcionalidades

### Área Pública

- Ver catálogo de productos
- Buscar productos por nombre o descripción

### Área Privada (Administrador)

- Iniciar sesión
- Listar productos
- Agregar nuevos productos
- Editar productos existentes
- Eliminar productos

## Buenas Prácticas Implementadas

- Arquitectura MVC
- PDO con sentencias preparadas
- Transacciones en operaciones críticas
- Manejo de errores con try-catch
- Namespaces y autoload propio
- Contraseñas hasheadas con bcrypt
- Prevención de SQL Injection
- Escape de salida con htmlspecialchars

## Autores

- Eduardo Montes de Oca Zatarain
- Abraham Paez Guerra
- Erik Watson Rosales
- Carlos Tirado Velazquez
