CREATE DATABASEautoescuela;
USE autoescuela;


CREATE TABLE clientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    apellidos VARCHAR(100) NOT NULL,
    dni VARCHAR(15) UNIQUE NOT NULL,
    telefono VARCHAR(15),
    email VARCHAR(100),
    borrado BOOLEAN DEFAULT FALSE
);


CREATE TABLE profesores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    apellidos VARCHAR(100) NOT NULL,
    dni VARCHAR(15) UNIQUE NOT NULL,
    telefono VARCHAR(15),
    email VARCHAR(100),
    borrado BOOLEAN DEFAULT FALSE
);


CREATE TABLE vehiculos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    matricula VARCHAR(10) UNIQUE NOT NULL,
    marca VARCHAR(50) NOT NULL,
    modelo VARCHAR(50) NOT NULL,
    anyo INT,
    borrado BOOLEAN DEFAULT FALSE
);


CREATE TABLE clases (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cliente_id INT NOT NULL,
    profesor_id INT NOT NULL,
    vehiculo_id INT NOT NULL,
    fecha DATE NOT NULL,
    hora TIME NOT NULL,
    borrado BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (cliente_id) REFERENCES clientes(id),
    FOREIGN KEY (profesor_id) REFERENCES profesores(id),
    FOREIGN KEY (vehiculo_id) REFERENCES vehiculos(id),
    UNIQUE KEY unique_cliente_dia (cliente_id, fecha),
    UNIQUE KEY unique_profesor_hora (profesor_id, fecha, hora),
    UNIQUE KEY unique_vehiculo_hora (vehiculo_id, fecha, hora)
);


INSERT INTO clientes (nombre, apellidos, dni, telefono, email) VALUES
('Juan', 'García Pérez', '12345678A', '600111111', 'juan.garcia@email.com'),
('María', 'López Sánchez', '23456789B', '600111222', 'maria.lopez@email.com'),
('Carlos', 'Martínez Ruiz', '34567890C', '600111333', 'carlos.martinez@email.com'),
('Ana', 'González Díaz', '45678901D', '600111444', 'ana.gonzalez@email.com'),
('David', 'Rodríguez Fernández', '56789012E', '600111555', 'david.rodriguez@email.com'),
('Laura', 'Sánchez Gómez', '67890123F', '600111666', 'laura.sanchez@email.com'),
('Javier', 'Fernández López', '78901234G', '600111777', 'javier.fernandez@email.com'),
('Elena', 'Díaz Martínez', '89012345H', '600111888', 'elena.diaz@email.com'),
('Miguel', 'Ruiz Sánchez', '90123456I', '600111999', 'miguel.ruiz@email.com'),
('Carmen', 'Pérez García', '01234567J', '600222111', 'carmen.perez@email.com'),
('Pablo', 'Gómez Rodríguez', '11223344K', '600222222', 'pablo.gomez@email.com'),
('Sara', 'Vázquez López', '22334455L', '600222333', 'sara.vazquez@email.com'),
('Daniel', 'Jiménez Ruiz', '33445566M', '600222444', 'daniel.jimenez@email.com'),
('Lucía', 'Moreno Sánchez', '44556677N', '600222555', 'lucia.moreno@email.com'),
('Alejandro', 'Álvarez Pérez', '55667788O', '600222666', 'alejandro.alvarez@email.com'),
('Marta', 'Romero García', '66778899P', '600222777', 'marta.romero@email.com'),
('Jorge', 'Navarro López', '77889900Q', '600222888', 'jorge.navarro@email.com'),
('Patricia', 'Muñoz Díaz', '88990011R', '600222999', 'patricia.munoz@email.com'),
('Sergio', 'Gutiérrez Sánchez', '99001122S', '600333111', 'sergio.gutierrez@email.com'),
('Isabel', 'Torres Martínez', '00112233T', '600333222', 'isabel.torres@email.com'),
('Raúl', 'Domínguez Ruiz', '11223344U', '600333333', 'raul.dominguez@email.com'),
('Nerea', 'Hernández Gómez', '22334455V', '600333444', 'nerea.hernandez@email.com'),
('Adrián', 'Castro López', '33445566W', '600333555', 'adrian.castro@email.com'),
('Cristina', 'Ortega Pérez', '44556677X', '600333666', 'cristina.ortega@email.com'),
('Iván', 'Rubio Sánchez', '55667788Y', '600333777', 'ivan.rubio@email.com'),
('Silvia', 'Molina García', '66778899Z', '600333888', 'silvia.molina@email.com'),
('Óscar', 'Delgado Fernández', '77889900AA', '600333999', 'oscar.delgado@email.com'),
('Rosa', 'Ramírez López', '88990011AB', '600444111', 'rosa.ramirez@email.com'),
('Rubén', 'Cano Martínez', '99001122AC', '600444222', 'ruben.cano@email.com'),
('Teresa', 'Herrera Díaz', '00112233AD', '600444333', 'teresa.herrera@email.com'),
('Alberto', 'Santos Ruiz', '11223344AE', '600444444', 'alberto.santos@email.com'),
('Paula', 'Lorenzo Gómez', '22334455AF', '600444555', 'paula.lorenzo@email.com'),
('Hugo', 'Marín Pérez', '33445566AG', '600444666', 'hugo.marin@email.com'),
('Eva', 'Suárez López', '44556677AH', '600444777', 'eva.suarez@email.com'),
('Ángel', 'Blanco Sánchez', '55667788AI', '600444888', 'angel.blanco@email.com'),
('Alicia', 'Iglesias García', '66778899AJ', '600444999', 'alicia.iglesias@email.com'),
('Víctor', 'Méndez Ruiz', '77889900AK', '600555111', 'victor.mendez@email.com'),
('Nuria', 'Cruz Fernández', '88990011AL', '600555222', 'nuria.cruz@email.com'),
('Francisco', 'Reyes López', '99001122AM', '600555333', 'francisco.reyes@email.com'),
('Beatriz', 'Peña Martínez', '00112233AN', '600555444', 'beatriz.pena@email.com'),
('Jesús', 'Vicente Sánchez', '11223344AO', '600555555', 'jesus.vicente@email.com'),
('Inés', 'Aguilar Díaz', '22334455AP', '600555666', 'ines.aguilar@email.com'),
('Manuel', 'Expósito Gómez', '33445566AQ', '600555777', 'manuel.exposito@email.com'),
('Rocío', 'Calvo Pérez', '44556677AR', '600555888', 'rocio.calvo@email.com'),
('Guillermo', 'Ferrández López', '55667788AS', '600555999', 'guillermo.ferrandez@email.com'),
('Lidia', 'Pastor Ruiz', '66778899AT', '600666111', 'lidia.pastor@email.com'),
('Marcos', 'Garrido Sánchez', '77889900AU', '600666222', 'marcos.garrido@email.com'),
('Olga', 'Luque García', '88990011AV', '600666333', 'olga.luque@email.com'),
('César', 'Montero Díaz', '99001122AW', '600666444', 'cesar.montero@email.com');


INSERT INTO profesores (nombre, apellidos, dni, telefono, email) VALUES
('Antonio', 'García López', '11111111A', '611111111', 'antonio.garcia@autoescuela.com'),
('Beatriz', 'Sánchez Ruiz', '22222222B', '611111222', 'beatriz.sanchez@autoescuela.com'),
('Carlos', 'Fernández Gómez', '33333333C', '611111333', 'carlos.fernandez@autoescuela.com'),
('Diana', 'Martínez Pérez', '44444444D', '611111444', 'diana.martinez@autoescuela.com'),
('Eduardo', 'López Sánchez', '55555555E', '611111555', 'eduardo.lopez@autoescuela.com'),
('Fernanda', 'González Díaz', '66666666F', '611111666', 'fernanda.gonzalez@autoescuela.com'),
('Gabriel', 'Rodríguez Fernández', '77777777G', '611111777', 'gabriel.rodriguez@autoescuela.com'),
('Helena', 'Pérez Martínez', '88888888H', '611111888', 'helena.perez@autoescuela.com'),
('Ignacio', 'Ruiz Sánchez', '99999999I', '611111999', 'ignacio.ruiz@autoescuela.com'),
('Julia', 'Torres García', '10101010J', '611222111', 'julia.torres@autoescuela.com');


INSERT INTO vehiculos (matricula, marca, modelo, anyo) VALUES
('1234ABC', 'Seat', 'Ibiza', 2020),
('2345BCD', 'Renault', 'Clio', 2021),
('3456CDE', 'Peugeot', '208', 2022),
('4567DEF', 'Ford', 'Fiesta', 2021),
('5678EFG', 'Toyota', 'Corolla', 2023);