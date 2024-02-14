-- --------------------------------------------------------
-- Base de datos: `presa_angulo_edurne_DWES04`
-- --------------------------------------------------------

--
-- CREACION BD
--
CREATE DATABASE IF NOT EXISTS presa_angulo_edurne_DWES04;
USE presa_angulo_edurne_DWES04;

-- --------------------------------------------------------
--
-- TABLA VEHICULOS
--
-- Creacion de tabla
CREATE TABLE VEHICULOS (
    ID_VEHICULO INT AUTO_INCREMENT PRIMARY KEY,
    MATRICULA VARCHAR(7) NOT NULL,
    TIPO ENUM('coche', 'furgoneta') NOT NULL,
    MARCA VARCHAR(20) NOT NULL,
    MODELO VARCHAR(20) NOT NULL,
    ANIO INT NOT NULL,
    COLOR VARCHAR(20) NOT NULL,
    KM INT NOT NULL,
    PRECIO DECIMAL(8,2) NOT NULL,
    COMBUSTIBLE ENUM('diesel', 'gasolina', 'electrico') NOT NULL,
    CATEGORIA ENUM('compacto', 'sedan', 'suv'),       -- SOLO en vehículos de tipo 'Coche'
    VOLUMEN_CARGA_M3 DECIMAL(10, 2),                  -- SOLO en vehículos de tipo 'Furgoneta'
    TAMANIO ENUM('corta', 'mediana', 'larga'),        -- SOLO en vehículos de tipo 'Furgoneta'

    -- CONSTRAINTS
    CONSTRAINT veh_mat_uq UNIQUE (MATRICULA)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Insercion de datos
INSERT INTO VEHICULOS (MATRICULA, TIPO, MARCA, MODELO, ANIO, COLOR, KM, PRECIO, COMBUSTIBLE, CATEGORIA) VALUES
('1223BBC', 'coche', 'Toyota', 'Camry', 2019, 'Plateado', 30000, 25000, 'gasolina', 'sedan'),
('4256DDF', 'coche', 'Honda', 'CR-V', 2018, 'Azul', 40000, 28000, 'diesel', 'suv'),
('7894GHF', 'coche', 'Ford', 'Focus', 2017, 'Rojo', 35000, 22000, 'gasolina', 'compacto'),
('3013PQR', 'coche', 'Volkswagen', 'Passat', 2018, 'Negro', 32000, 26000, 'electrico', 'sedan'),
('5035VWX', 'coche', 'Mercedes-Benz', 'GLE', 2016, 'Plata', 50000, 35000, 'gasolina', 'suv'),
('6206YZG', 'coche', 'Audi', 'A3', 2019, 'Amarillo', 28000, 28000, 'diesel', 'compacto');

INSERT INTO VEHICULOS (MATRICULA, TIPO, MARCA, MODELO, ANIO, COLOR, KM, PRECIO, COMBUSTIBLE, VOLUMEN_CARGA_M3, TAMANIO) VALUES 
('1021JKL', 'furgoneta', 'Chevrolet', 'Express', 2019, 'Blanco', 25000, 30000, 'gasolina', 3, 'corta'),
('2042MNR', 'furgoneta', 'Nissan', 'NV200', 2016, 'Gris', 60000, 18000, 'diesel', 6, 'mediana'),
('4034STF', 'furgoneta', 'BMW', 'X3', 2017, 'Verde', 45000, 32000, 'diesel', 12, 'larga'),
('7077BCD', 'furgoneta', 'Hyundai', 'H1', 2018, 'Morado', 38000, 30000, 'gasolina', 3, 'corta');


-- --------------------------------------------------------
--
-- TABLA COCHES
--
-- Creacion de tabla
CREATE TABLE COCHES (
  ID_VEHICULO INT PRIMARY KEY,
  MATRICULA VARCHAR(7) NOT NULL,
  TIPO ENUM('coche') NOT NULL,
  MARCA VARCHAR(20) NOT NULL,
  MODELO VARCHAR(20) NOT NULL,
  ANIO INT NOT NULL,
  COLOR VARCHAR(20) NOT NULL,
  KM INT NOT NULL,
  PRECIO DECIMAL(8,2) NOT NULL,
  COMBUSTIBLE ENUM('diesel', 'gasolina', 'electrico') NOT NULL,
  CATEGORIA ENUM('compacto', 'sedan', 'suv'),

  -- CONSTRAINTS 
  CONSTRAINT coc_mat_uq UNIQUE (MATRICULA),
  CONSTRAINT coc_id_fk FOREIGN KEY (ID_VEHICULO) REFERENCES VEHICULOS (ID_VEHICULO)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Insercion de datos
INSERT INTO COCHES (ID_VEHICULO, MATRICULA, TIPO, MARCA, MODELO, ANIO, COLOR, KM, PRECIO, COMBUSTIBLE, CATEGORIA) VALUES
(1, '1223BBC', 'coche', 'Toyota', 'Camry', 2019, 'Plateado', 30000, 25000, 'gasolina', 'sedan'),
(2, '4256DDF', 'coche', 'Honda', 'CR-V', 2018, 'Azul', 40000, 28000, 'diesel', 'suv'),
(3, '7894GHF', 'coche', 'Ford', 'Focus', 2017, 'Rojo', 35000, 22000, 'gasolina', 'compacto'),
(4, '3013PQR', 'coche', 'Volkswagen', 'Passat', 2018, 'Negro', 32000, 26000, 'electrico', 'sedan'),
(5, '5035VWX', 'coche', 'Mercedes-Benz', 'GLE', 2016, 'Plata', 50000, 35000, 'gasolina', 'suv'),
(6, '6206YZG', 'coche', 'Audi', 'A3', 2019, 'Amarillo', 28000, 28000, 'diesel', 'compacto');

-- --------------------------------------------------------
--
-- TABLA FURGONETAS
--
-- Creacion de tabla
CREATE TABLE FURGONETAS (
  ID_VEHICULO INT PRIMARY KEY,
  MATRICULA VARCHAR(7) NOT NULL,
  TIPO ENUM('furgoneta') NOT NULL,
  MARCA VARCHAR(20) NOT NULL,
  MODELO VARCHAR(20) NOT NULL,
  ANIO INT NOT NULL,
  COLOR VARCHAR(20) NOT NULL,
  KM INT NOT NULL,
  PRECIO DECIMAL(8,2) NOT NULL,
  COMBUSTIBLE ENUM('diesel', 'gasolina', 'electrico') NOT NULL,
  VOLUMEN_CARGA_M3 DECIMAL(10, 2),
  TAMANIO ENUM('corta', 'mediana', 'larga'),

  -- CONSTRAINTS
  CONSTRAINT fur_mat_uq UNIQUE (MATRICULA),
  CONSTRAINT fur_id_fk FOREIGN KEY (ID_VEHICULO) REFERENCES VEHICULOS (ID_VEHICULO)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Insercion de datos

INSERT INTO FURGONETAS (ID_VEHICULO, MATRICULA, TIPO, MARCA, MODELO, ANIO, COLOR, KM, PRECIO, COMBUSTIBLE, VOLUMEN_CARGA_M3, TAMANIO) VALUES 
(7, '1021JKL', 'furgoneta', 'Chevrolet', 'Express', 2019, 'Blanco', 25000, 30000, 'gasolina', 3, 'corta'),
(8, '2042MNR', 'furgoneta', 'Nissan', 'NV200', 2016, 'Gris', 60000, 18000, 'diesel', 6, 'mediana'),
(9, '4034STF', 'furgoneta', 'BMW', 'X3', 2017, 'Verde', 45000, 32000, 'diesel', 12, 'larga'),
(10, '7077BCD', 'furgoneta', 'Hyundai', 'H1', 2018, 'Morado', 38000, 30000, 'gasolina', 3, 'corta');

COMMIT;