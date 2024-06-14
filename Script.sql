-- Crear la base de datos
CREATE DATABASE multimedios022;

-- Usar la base de datos
USE multimedios022;

-- Crear la tabla Usuarios
CREATE TABLE Usuarios (
    id INT IDENTITY(1,1) PRIMARY KEY,
    nombre NVARCHAR(255) NOT NULL,
    email NVARCHAR(255) UNIQUE NOT NULL,
    password NVARCHAR(255) NOT NULL,
    rol NVARCHAR(50)
);

-- Crear la tabla Proveedores
CREATE TABLE Proveedores (
    id INT IDENTITY(1,1) PRIMARY KEY,
    nombre NVARCHAR(255) NOT NULL,
    contacto NVARCHAR(255),
    direccion NVARCHAR(MAX),
    creado_por INT,
    modificado_por INT,
    FOREIGN KEY (creado_por) REFERENCES Usuarios(id),
    FOREIGN KEY (modificado_por) REFERENCES Usuarios(id)
);

-- Crear la tabla Productos
CREATE TABLE Productos (
    id INT IDENTITY(1,1) PRIMARY KEY,
    nombre NVARCHAR(255) NOT NULL,
    descripcion NVARCHAR(MAX),
    precio DECIMAL(10, 2),
    proveedor_id INT,
    estado NVARCHAR(50),
    creado_por INT,
    modificado_por INT,
    FOREIGN KEY (proveedor_id) REFERENCES Proveedores(id),
    FOREIGN KEY (creado_por) REFERENCES Usuarios(id),
    FOREIGN KEY (modificado_por) REFERENCES Usuarios(id)
);

-- Crear la tabla Inventarios
CREATE TABLE Inventarios (
    id INT IDENTITY(1,1) PRIMARY KEY,
    producto_id INT,
    cantidad INT,
    ubicacion NVARCHAR(255),
    creado_por INT,
    modificado_por INT,
    FOREIGN KEY (producto_id) REFERENCES Productos(id),
    FOREIGN KEY (creado_por) REFERENCES Usuarios(id),
    FOREIGN KEY (modificado_por) REFERENCES Usuarios(id)
);
