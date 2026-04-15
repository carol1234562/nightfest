CREATE DATABASE NightFest;
USE NightFest;

CREATE TABLE IF NOT EXISTS usuarios (     
id INT AUTO_INCREMENT PRIMARY KEY,     
nombre VARCHAR(100) NOT NULL,     
email VARCHAR(150) NOT NULL UNIQUE,     
password VARCHAR(255) NOT NULL,     
rol ENUM('estandar', 'admin') DEFAULT 'estandar',     
foto_perfil VARCHAR(255) DEFAULT 'default.png',     
fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP, 
INDEX (email) 
) ENGINE=InnoDB DEFAULT 
CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO usuarios (nombre, email, password, rol) 
VALUES ('Administrador', 'admin@correo.com', 'd4wphp1', 'admin');

INSERT INTO usuarios (nombre, email, password, rol) 
VALUES ('Administrador', 'carol@correo.com', '12345', 'admin');