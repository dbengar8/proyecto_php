CREATE TABLE IF NOT EXISTS provincias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL
);

CREATE TABLE IF NOT EXISTS departamentos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL
);

CREATE TABLE IF NOT EXISTS sedes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    provincia_id INT,
    FOREIGN KEY (provincia_id) REFERENCES provincias(id)
);

CREATE TABLE IF NOT EXISTS empleados (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    apellidos VARCHAR(100) NOT NULL,
    dni VARCHAR(20) NOT NULL,
    email VARCHAR(100) NOT NULL,
    telefono VARCHAR(20),
    fecha_alta DATE,
    sede_id INT,
    departamento_id INT,
    FOREIGN KEY (sede_id) REFERENCES sedes(id),
    FOREIGN KEY (departamento_id) REFERENCES departamentos(id)
);

-- Insertar datos iniciales
INSERT INTO provincias (nombre) VALUES ('Madrid'), ('Barcelona'), ('Valencia'), ('Sevilla');
INSERT INTO departamentos (nombre) VALUES ('IT'), ('RRHH'), ('Marketing'), ('Finanzas');
INSERT INTO sedes (nombre, provincia_id) VALUES 
('Sede Central', 1),
('Delegación Norte', 2),
('Oficina Sur', 4),
('Hub Tecnológico', 3);