-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 25-10-2023 a las 14:41:06
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `gimnasiobd`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `admin`
--

CREATE TABLE `admin` (
  `idAdmin` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `admin`
--

INSERT INTO `admin` (`idAdmin`) VALUES
(215);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `idCliente` int(11) NOT NULL,
  `idEntrenador` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`idCliente`, `idEntrenador`) VALUES
(217, NULL),
(218, 216),
(220, 216),
(219, 222),
(221, 222);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente_has_entrenamientos`
--

CREATE TABLE `cliente_has_entrenamientos` (
  `idCliente` int(11) NOT NULL,
  `idEntrenamiento` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `cliente_has_entrenamientos`
--

INSERT INTO `cliente_has_entrenamientos` (`idCliente`, `idEntrenamiento`) VALUES
(217, 1),
(217, 3),
(218, 1),
(218, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `datosusuario`
--

CREATE TABLE `datosusuario` (
  `idDatosUsuario` int(11) NOT NULL,
  `email` varchar(75) NOT NULL,
  `nombre` varchar(25) NOT NULL,
  `pass` varchar(15) NOT NULL,
  `rol` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `datosusuario`
--

INSERT INTO `datosusuario` (`idDatosUsuario`, `email`, `nombre`, `pass`, `rol`) VALUES
(215, 'alex@mail.com', 'alex', 'password', 'admin'),
(216, 'entrenador@mail.com', 'entrenador', 'password', 'entrenador'),
(217, 'cliente@mail.com', 'cliente', 'password', 'cliente'),
(218, 'pedro@mail.com', 'pedro', 'password', 'cliente'),
(219, 'jaime@mail.com', 'jaime', 'password', 'cliente'),
(220, 'fran@mail.com', 'fran', 'password', 'cliente'),
(221, 'rafael@mail.com', 'rafael', 'password', 'cliente'),
(222, 'juan@mail.com', 'juan', 'password', 'entrenador');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ejercicio`
--

CREATE TABLE `ejercicio` (
  `idEjercicio` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `descripcion` varchar(400) DEFAULT NULL,
  `repeticiones` varchar(15) DEFAULT NULL,
  `duracion` varchar(75) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `ejercicio`
--

INSERT INTO `ejercicio` (`idEjercicio`, `nombre`, `descripcion`, `repeticiones`, `duracion`) VALUES
(12, 'Calentamiento', 'trotar durante unos cinco mim y luego hacer ejercicios de estiramiento', '1', '5 mim'),
(13, 'pres de banca', 'Hacer 3 series de 12 repeticiones con un 80% del peso máximo que puedas levantar', '12', '5');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ejercicios_has_entrenamientos`
--

CREATE TABLE `ejercicios_has_entrenamientos` (
  `idEjercicios` int(11) NOT NULL,
  `idEntrenamiento` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `ejercicios_has_entrenamientos`
--

INSERT INTO `ejercicios_has_entrenamientos` (`idEjercicios`, `idEntrenamiento`) VALUES
(12, 1),
(12, 2),
(12, 3),
(13, 1),
(13, 2),
(13, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entrenador`
--

CREATE TABLE `entrenador` (
  `idEntrenador` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `entrenador`
--

INSERT INTO `entrenador` (`idEntrenador`) VALUES
(216),
(222);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entrenamiento`
--

CREATE TABLE `entrenamiento` (
  `dia` varchar(25) DEFAULT NULL,
  `nombre` varchar(100) NOT NULL,
  `entrenador` int(11) NOT NULL,
  `idEntrenamiento` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `entrenamiento`
--

INSERT INTO `entrenamiento` (`dia`, `nombre`, `entrenador`, `idEntrenamiento`) VALUES
('Entrenamiento 1', 'lunes', 216, 1),
('entrenamiento 3', 'lunes', 222, 2),
('correr mucho 2', 'lunes', 216, 3);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`idAdmin`),
  ADD KEY `fk_Admin_Datos_usuarios1_idx` (`idAdmin`);

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`idCliente`),
  ADD KEY `fk_Cliente_Datos_usuarios1_idx` (`idCliente`),
  ADD KEY `fk_Cliente_Entrenador1_idx` (`idEntrenador`),
  ADD KEY `Entrenador_Datos_usuarios_id_datos_usuarios_UNIQUE` (`idEntrenador`) USING BTREE;

--
-- Indices de la tabla `cliente_has_entrenamientos`
--
ALTER TABLE `cliente_has_entrenamientos`
  ADD PRIMARY KEY (`idCliente`,`idEntrenamiento`),
  ADD KEY `fk_Cliente_has_Entrenamientos_Entrenamientos1_idx` (`idEntrenamiento`),
  ADD KEY `fk_Cliente_has_Entrenamientos_Cliente1_idx` (`idCliente`);

--
-- Indices de la tabla `datosusuario`
--
ALTER TABLE `datosusuario`
  ADD PRIMARY KEY (`idDatosUsuario`),
  ADD UNIQUE KEY `email_UNIQUE` (`email`);

--
-- Indices de la tabla `ejercicio`
--
ALTER TABLE `ejercicio`
  ADD PRIMARY KEY (`idEjercicio`),
  ADD UNIQUE KEY `idEjercicios_UNIQUE` (`idEjercicio`);

--
-- Indices de la tabla `ejercicios_has_entrenamientos`
--
ALTER TABLE `ejercicios_has_entrenamientos`
  ADD PRIMARY KEY (`idEjercicios`,`idEntrenamiento`),
  ADD KEY `fk_Ejercicios_has_Entrenamientos_Ejercicios2_idx` (`idEjercicios`),
  ADD KEY `fk_Ejercicios_has_Entrenamientos_Entrenamientos1_idx` (`idEntrenamiento`);

--
-- Indices de la tabla `entrenador`
--
ALTER TABLE `entrenador`
  ADD PRIMARY KEY (`idEntrenador`),
  ADD KEY `fk_Entrenador_Datos_usuarios1_idx` (`idEntrenador`);

--
-- Indices de la tabla `entrenamiento`
--
ALTER TABLE `entrenamiento`
  ADD PRIMARY KEY (`idEntrenamiento`),
  ADD UNIQUE KEY `idEntrenamiento_UNIQUE` (`idEntrenamiento`),
  ADD KEY `fk_Entrenamiento_Entrenador1_idx` (`entrenador`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `datosusuario`
--
ALTER TABLE `datosusuario`
  MODIFY `idDatosUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=223;

--
-- AUTO_INCREMENT de la tabla `ejercicio`
--
ALTER TABLE `ejercicio`
  MODIFY `idEjercicio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `entrenamiento`
--
ALTER TABLE `entrenamiento`
  MODIFY `idEntrenamiento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `admin`
--
ALTER TABLE `admin`
  ADD CONSTRAINT `fk_Admin_Datos_usuarios1` FOREIGN KEY (`idAdmin`) REFERENCES `datosusuario` (`idDatosUsuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD CONSTRAINT `fk_Cliente_Datos_usuarios1` FOREIGN KEY (`idCliente`) REFERENCES `datosusuario` (`idDatosUsuario`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_Cliente_Entrenador1` FOREIGN KEY (`idEntrenador`) REFERENCES `entrenador` (`idEntrenador`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `cliente_has_entrenamientos`
--
ALTER TABLE `cliente_has_entrenamientos`
  ADD CONSTRAINT `fk_Cliente_has_Entrenamientos_Cliente1` FOREIGN KEY (`idCliente`) REFERENCES `cliente` (`idCliente`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Cliente_has_Entrenamientos_Entrenamientos1` FOREIGN KEY (`idEntrenamiento`) REFERENCES `entrenamiento` (`idEntrenamiento`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `ejercicios_has_entrenamientos`
--
ALTER TABLE `ejercicios_has_entrenamientos`
  ADD CONSTRAINT `fk_Ejercicios_has_Entrenamientos_Ejercicios2` FOREIGN KEY (`idEjercicios`) REFERENCES `ejercicio` (`idEjercicio`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_Ejercicios_has_Entrenamientos_Entrenamientos1` FOREIGN KEY (`idEntrenamiento`) REFERENCES `entrenamiento` (`idEntrenamiento`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `entrenador`
--
ALTER TABLE `entrenador`
  ADD CONSTRAINT `fk_Entrenador_Datos_usuarios1` FOREIGN KEY (`idEntrenador`) REFERENCES `datosusuario` (`idDatosUsuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `entrenamiento`
--
ALTER TABLE `entrenamiento`
  ADD CONSTRAINT `fk_Entrenamiento_Entrenador1` FOREIGN KEY (`entrenador`) REFERENCES `entrenador` (`idEntrenador`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
