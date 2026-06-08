-- =====================================================
-- Script SQL Completo para el Sistema MVC con PHP
-- Tienda MVC - Base de Datos (con mejoras extras)
-- =====================================================

CREATE DATABASE IF NOT EXISTS tienda_mvc CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE tienda_mvc;

-- Tabla de usuarios (administradores)
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    nombre_completo VARCHAR(100) NOT NULL
);

-- Tabla de productos (con campo imagen)
CREATE TABLE IF NOT EXISTS productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sku VARCHAR(50) NOT NULL UNIQUE,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT NOT NULL,
    precio_compra DECIMAL(10,2) NOT NULL,
    precio_venta DECIMAL(10,2) NOT NULL,
    existencia INT NOT NULL DEFAULT 0,
    imagen LONGTEXT DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabla de bitácora (log de acciones del admin)
CREATE TABLE IF NOT EXISTS logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    usuario_nombre VARCHAR(100) NOT NULL,
    accion VARCHAR(255) NOT NULL,
    detalle TEXT,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);

-- Insertar usuario administrador
-- Contraseña: admin123 (hash bcrypt)
INSERT INTO usuarios (username, password, nombre_completo)
VALUES ('admin', '$2a$10$ZRDvXI1bNcmq7K7ocTikUOfYaCfj3TvA7zFNDKtonYHOtm33gDgc.', 'Administrador General');

-- Datos de ejemplo para productos
INSERT INTO productos (sku, nombre, descripcion, precio_compra, precio_venta, existencia) VALUES
('SKU-001', 'Laptop HP ProBook', 'Laptop HP ProBook 450 G8, Intel Core i5, 8GB RAM, 256GB SSD', 12000.00, 15999.99, 10),
('SKU-002', 'Mouse Logitech MX Master', 'Mouse inalámbrico ergonómico Logitech MX Master 3S', 800.00, 1299.99, 25),
('SKU-003', 'Teclado Mecánico Corsair', 'Teclado mecánico Corsair K70 RGB, switches Cherry MX Red', 1500.00, 2499.99, 15),
('SKU-004', 'Monitor Samsung 27"', 'Monitor Samsung 27 pulgadas, resolución 4K UHD, panel IPS', 5000.00, 7499.99, 8),
('SKU-005', 'Audífonos Sony WH-1000XM5', 'Audífonos inalámbricos con cancelación de ruido activa', 4500.00, 6999.99, 12),
('SKU-006', 'Webcam Logitech C920', 'Webcam HD 1080p con micrófono estéreo integrado', 900.00, 1499.99, 20),
('SKU-007', 'Disco Duro Externo 1TB', 'Disco duro portátil Seagate 1TB USB 3.0', 600.00, 999.99, 30),
('SKU-008', 'Memoria USB 64GB', 'Memoria flash Kingston DataTraveler 64GB USB 3.2', 100.00, 199.99, 50),
('SKU-009', 'Cable HDMI 2.1', 'Cable HDMI 2.1 de alta velocidad, 2 metros, 8K', 150.00, 349.99, 40),
('SKU-010', 'Hub USB-C 7 en 1', 'Adaptador multipuerto USB-C con HDMI, USB 3.0 y lector SD', 350.00, 699.99, 18),
('SKU-011', 'Mousepad Gaming XL', 'Alfombrilla de ratón gaming RGB, superficie extendida', 200.00, 449.99, 35),
('SKU-012', 'Silla Ergonómica', 'Silla de oficina ergonómica con soporte lumbar ajustable', 3500.00, 5999.99, 5);
