-- =====================================================
-- Base de Datos: El Campesino MiniMarket
-- Motor: MySQL 8.0+ / MariaDB (MySQL Workbench)
-- =====================================================

DROP DATABASE IF EXISTS el_campesino;
CREATE DATABASE el_campesino CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE el_campesino;

-- 1. USUARIOS Y CONTROL DE ACCESO (Módulo 1 y 7)
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(120) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    rol ENUM('ADMIN', 'EMPLEADO', 'REPARTIDOR', 'CLIENTE') NOT NULL DEFAULT 'CLIENTE',
    telefono VARCHAR(20),
    direccion VARCHAR(255),
    intentos_fallidos TINYINT UNSIGNED DEFAULT 0,
    bloqueado BOOLEAN DEFAULT FALSE,
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- 2. CATEGORÍAS
CREATE TABLE categorias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(60) NOT NULL UNIQUE,
    descripcion VARCHAR(255)
) ENGINE=InnoDB;

-- 3. PRODUCTOS
CREATE TABLE productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    categoria_id INT NOT NULL,
    nombre VARCHAR(120) NOT NULL,
    codigo_barras VARCHAR(50) UNIQUE,
    precio DECIMAL(10, 2) NOT NULL,
    stock_minimo DECIMAL(10, 2) NOT NULL DEFAULT 5.00,
    unidad_medida ENUM('KG', 'LB', 'UNIDAD', 'PAQUETE') NOT NULL DEFAULT 'KG',
    imagen_url VARCHAR(255),
    activo BOOLEAN DEFAULT TRUE,
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (categoria_id) REFERENCES categorias(id) ON DELETE RESTRICT
) ENGINE=InnoDB;

-- 4. PROVEEDORES (Módulo 6)
CREATE TABLE proveedores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(120) NOT NULL,
    nit_cedula VARCHAR(30) UNIQUE,
    telefono VARCHAR(20),
    email VARCHAR(120),
    direccion VARCHAR(255),
    activo BOOLEAN DEFAULT TRUE
) ENGINE=InnoDB;

-- 5. LOTES DE INVENTARIO Y FECHAS DE VENCIMIENTO (Módulo 2 y 5)
CREATE TABLE lotes_inventario (
    id INT AUTO_INCREMENT PRIMARY KEY,
    producto_id INT NOT NULL,
    proveedor_id INT,
    numero_lote VARCHAR(50) NOT NULL,
    stock_actual DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
    costo_compra DECIMAL(10, 2) NOT NULL,
    fecha_ingreso DATE NOT NULL,
    fecha_vencimiento DATE NOT NULL,
    FOREIGN KEY (producto_id) REFERENCES productos(id) ON DELETE CASCADE,
    FOREIGN KEY (proveedor_id) REFERENCES proveedores(id) ON DELETE SET NULL,
    INDEX idx_vencimiento (fecha_vencimiento)
) ENGINE=InnoDB;

-- 6. MOVIMIENTOS KARDEX (Módulo 3 y 4)
CREATE TABLE movimientos_kardex (
    id INT AUTO_INCREMENT PRIMARY KEY,
    producto_id INT NOT NULL,
    lote_id INT,
    usuario_id INT NOT NULL,
    tipo ENUM('ENTRADA', 'SALIDA', 'AJUSTE') NOT NULL,
    cantidad DECIMAL(10, 2) NOT NULL,
    motivo VARCHAR(255) NOT NULL,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (producto_id) REFERENCES productos(id) ON DELETE RESTRICT,
    FOREIGN KEY (lote_id) REFERENCES lotes_inventario(id) ON DELETE SET NULL,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE RESTRICT
) ENGINE=InnoDB;

-- 7. PEDIDOS Y DOMICILIOS (Módulo Recepción y Despacho)
CREATE TABLE pedidos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cliente_id INT NOT NULL,
    repartidor_id INT NULL,
    estado ENUM('REGISTRADO', 'EN_PREPARACION', 'LISTO_DESPACHO', 'EN_RUTA', 'ENTREGADO', 'CANCELADO') NOT NULL DEFAULT 'REGISTRADO',
    total DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
    direccion_entrega VARCHAR(255) NOT NULL,
    telefono_contacto VARCHAR(20) NOT NULL,
    metodo_pago ENUM('EFECTIVO', 'TRANSFERENCIA', 'DATAFONO') NOT NULL DEFAULT 'EFECTIVO',
    notas_entrega TEXT,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (cliente_id) REFERENCES usuarios(id) ON DELETE RESTRICT,
    FOREIGN KEY (repartidor_id) REFERENCES usuarios(id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- 8. DETALLE DE PEDIDOS
CREATE TABLE detalle_pedidos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pedido_id INT NOT NULL,
    producto_id INT NOT NULL,
    lote_id INT NULL,
    cantidad DECIMAL(10, 2) NOT NULL,
    precio_unitario DECIMAL(10, 2) NOT NULL,
    subtotal DECIMAL(10, 2) GENERATED ALWAYS AS (cantidad * precio_unitario) STORED,
    FOREIGN KEY (pedido_id) REFERENCES pedidos(id) ON DELETE CASCADE,
    FOREIGN KEY (producto_id) REFERENCES productos(id) ON DELETE RESTRICT,
    FOREIGN KEY (lote_id) REFERENCES lotes_inventario(id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- =====================================================
-- DATOS SEMILLA BÁSICOS (Para pruebas inmediatas)
-- =====================================================
INSERT INTO categorias (nombre, descripcion) VALUES 
('Carnes Rojas', 'Cortes de res y cerdo'),
('Pollos', 'Pollo campesino y despresado'),
('Abarrotes', 'Granos, aceites y víveres');

INSERT INTO usuarios (nombre, email, password_hash, rol) VALUES 
('Administrador', 'admin@campesino.com', 'hash_admin', 'ADMIN'),
('Cajero Turno', 'cajero@campesino.com', 'hash_cajero', 'EMPLEADO'),
('Carlos Repartidor', 'carlos@campesino.com', 'hash_repartidor', 'REPARTIDOR');
