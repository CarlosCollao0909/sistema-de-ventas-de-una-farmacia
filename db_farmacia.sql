-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 16-05-2024 a las 03:48:08
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
-- Base de datos: `db_farmacia`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `ID_Categoria` int(11) NOT NULL,
  `nombre` varchar(30) DEFAULT NULL,
  `descripcion` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`ID_Categoria`, `nombre`, `descripcion`) VALUES
(1, 'Analgésicos', 'Medicamentos para el alivio del dolor.'),
(2, 'Antibióticos', 'Medicamentos para combatir infecciones bacterianas'),
(3, 'Antiinflamatorios', 'Medicamentos para reducir la inflamación y el dolo'),
(4, 'Antipiréticos', 'Medicamentos para reducir la fiebre.'),
(5, 'Antidepresivos', 'Medicamentos para tratar la depresión y otros tras'),
(6, 'Anticoagulantes', 'Medicamentos para prevenir la formación de coágulo'),
(7, 'Broncodilatadores', 'Medicamentos para tratar el asma y otras enfermeda'),
(8, 'Diuréticos', 'Medicamentos para aumentar la eliminación de líqui'),
(9, 'Hipotensores', 'Medicamentos para reducir la presión arterial alta'),
(10, 'Sedantes', 'Medicamentos para inducir la relajación y el sueño'),
(11, 'Antiácidos', 'Alivia la acidez estomacal'),
(12, 'Laxantes', 'Facilita la evacuación intestinal');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `ID_Cliente` int(11) NOT NULL,
  `nombre` varchar(30) DEFAULT NULL,
  `apellido` varchar(30) DEFAULT NULL,
  `telefono` varchar(25) DEFAULT NULL,
  `ci_nit` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`ID_Cliente`, `nombre`, `apellido`, `telefono`, `ci_nit`) VALUES
(1, 'Juan Carlos', 'Collao Mamani', '69575687', 7370250),
(2, 'Pedro', 'Collao Beltran', '72326588', 3036520),
(3, 'Virginia', 'Mamani Choque', '75427888', 6236410),
(4, 'Ana Mariel', 'Collao Mamani', '70432154', 5231203),
(5, 'Miguel', 'Barco Viña', '72471353', 4152638),
(6, 'Gabriel', 'Pinto Tapia', '70425698', 5412366),
(7, 'Alberto', 'Cuevas', '68423641', 3265410),
(8, 'Ana ', 'Lopez', '78952361', 4156302),
(9, 'Magdalena', 'Rios', '74132021', 6532011),
(10, 'Julian ', 'Gaviria', '74526314', 4750201),
(11, 'Luis', 'Alvarado', '75423695', 4965270),
(12, 'Valentina', 'Mendez Perez', '65324108', 8532102);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_venta`
--

CREATE TABLE `detalle_venta` (
  `ID_Detalle` int(11) NOT NULL,
  `ID_Venta` int(11) DEFAULT NULL,
  `ID_Farmaco` int(11) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `subtotal` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalle_venta`
--

INSERT INTO `detalle_venta` (`ID_Detalle`, `ID_Venta`, `ID_Farmaco`, `cantidad`, `subtotal`) VALUES
(1, 1, 2, 3, 13.50),
(2, 1, 6, 4, 14.00),
(3, 1, 9, 6, 72.00),
(4, 2, 3, 5, 27.50),
(5, 2, 10, 3, 17.40),
(6, 2, 5, 6, 27.00),
(7, 3, 2, 11, 49.50),
(8, 3, 8, 15, 142.50),
(9, 4, 10, 8, 46.40),
(10, 4, 4, 6, 33.00),
(11, 4, 9, 7, 84.00),
(12, 4, 8, 3, 28.50),
(13, 5, 5, 5, 22.50),
(14, 5, 8, 3, 28.50),
(15, 5, 6, 2, 7.00),
(16, 5, 1, 8, 68.00),
(17, 6, 4, 6, 33.00),
(18, 6, 6, 4, 14.00),
(19, 6, 7, 3, 21.00),
(20, 6, 9, 5, 60.00),
(21, 7, 8, 12, 114.00),
(22, 7, 3, 2, 11.00),
(23, 8, 2, 7, 31.50),
(24, 8, 6, 6, 21.00),
(25, 8, 4, 5, 27.50),
(26, 9, 8, 8, 76.00),
(27, 9, 7, 3, 21.00),
(28, 9, 1, 2, 17.00),
(29, 10, 7, 2, 14.00),
(30, 10, 2, 3, 13.50),
(31, 10, 8, 12, 114.00),
(32, 11, 2, 25, 112.50),
(33, 11, 8, 30, 285.00),
(34, 12, 2, 30, 135.00),
(35, 12, 4, 2, 11.00),
(36, 13, 3, 2, 11.00),
(37, 13, 9, 4, 48.00),
(38, 14, 2, 3, 13.50),
(39, 15, 2, 2, 9.00),
(40, 15, 10, 4, 23.20),
(41, 16, 2, 5, 22.50),
(42, 16, 8, 4, 38.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `farmaco`
--

CREATE TABLE `farmaco` (
  `ID_Farmaco` int(11) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `precio_Compra` decimal(10,2) DEFAULT NULL,
  `precio_Venta` decimal(10,2) DEFAULT NULL,
  `stock` int(11) DEFAULT NULL,
  `ID_Proveedor` int(11) DEFAULT NULL,
  `ID_Categoria` int(11) DEFAULT NULL,
  `fecha_vencimiento` date DEFAULT NULL,
  `presentacion` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `farmaco`
--

INSERT INTO `farmaco` (`ID_Farmaco`, `nombre`, `precio_Compra`, `precio_Venta`, `stock`, `ID_Proveedor`, `ID_Categoria`, `fecha_vencimiento`, `presentacion`) VALUES
(1, 'Ibuprofeno', 6.50, 8.50, 90, 1, 3, '2024-06-30', 'Jarabe'),
(2, 'Amoxicilina', 3.00, 4.50, 11, 1, 2, '2025-04-08', 'Tableta'),
(3, 'Omeprazol', 3.00, 5.50, 91, 1, 4, '2026-07-11', 'Tableta'),
(4, 'Tosalcos', 3.60, 5.50, 81, 1, 1, '2025-03-21', 'Tableta'),
(5, 'Paracetamol', 3.50, 4.50, 89, 1, 3, '2024-07-19', 'Pomada'),
(6, 'Aspirina', 2.50, 3.50, 84, 2, 1, '2026-05-29', 'Tableta'),
(7, 'Naproxeno', 5.00, 7.00, 92, 2, 3, '2026-09-15', 'Ampolla'),
(8, 'Ciprofloxacina', 6.50, 9.50, 13, 3, 2, '2026-10-20', 'Pomada'),
(9, 'Sertralina', 8.00, 12.00, 78, 5, 5, '2024-07-03', 'Jarabe'),
(10, 'Dipirona', 4.00, 5.80, 85, 4, 1, '2026-11-30', 'Ampolla'),
(11, 'Fluoxetina', 7.50, 10.50, 100, 3, 5, '2024-06-29', 'Jarabe'),
(12, 'Diclofenaco', 7.50, 10.00, 100, 1, 3, '2025-02-01', 'Pomada');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personal`
--

CREATE TABLE `personal` (
  `ID_Personal` int(11) NOT NULL,
  `nombre` varchar(30) DEFAULT NULL,
  `apellido` varchar(30) DEFAULT NULL,
  `telefono` varchar(25) DEFAULT NULL,
  `direccion` varchar(50) DEFAULT NULL,
  `email` varchar(30) DEFAULT NULL,
  `contrasena` varchar(30) DEFAULT NULL,
  `rol` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `personal`
--

INSERT INTO `personal` (`ID_Personal`, `nombre`, `apellido`, `telefono`, `direccion`, `email`, `contrasena`, `rol`) VALUES
(1, 'José', 'Ochoa', '75425189', 'Velasco, Campo Jordán', 'jose8ovho19@gmail.com', 'C75425189', 'Ventas'),
(2, 'Juan', 'Collao', '69575687', 'Av. heroes del chaco, campo jordan', 'carloscollao@gmail.com', '12345678', 'Administrador'),
(3, 'Martha', 'Rojas', '65327452', 'Sargento Flores, Pagador', 'martha@gmail.com', '12345', 'Almacenes');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedor`
--

CREATE TABLE `proveedor` (
  `ID_Proveedor` int(11) NOT NULL,
  `nombre` varchar(35) DEFAULT NULL,
  `telefono` varchar(25) DEFAULT NULL,
  `direccion` varchar(50) DEFAULT NULL,
  `email` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `proveedor`
--

INSERT INTO `proveedor` (`ID_Proveedor`, `nombre`, `telefono`, `direccion`, `email`) VALUES
(1, 'INTI', '74586321', 'Sargento Flores, Pagador', 'lab_inti@gmail.com'),
(2, 'ALCOS', '79636241', 'Calle Beni', 'lab_alcos@gmail.com'),
(3, 'BAGÓ', '79636514', 'Calle San Felipe, Av. Brasil', 'lab_bagó@gmail.com'),
(4, 'IFA', '61253045', 'Av. Ejército, Tacna', 'lab_ifa@gmail.com'),
(5, 'VITA', '79685210', 'Av. Brasil, Montesinos', 'lab_vita@gmail.com'),
(6, 'COFAR', '64789652', 'Calle Rodriguez, Tarapacá', 'lab_cofar@gmail.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `venta`
--

CREATE TABLE `venta` (
  `ID_Venta` int(11) NOT NULL,
  `ID_Cliente` int(11) DEFAULT NULL,
  `ID_Personal` int(11) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `total_Venta` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `venta`
--

INSERT INTO `venta` (`ID_Venta`, `ID_Cliente`, `ID_Personal`, `fecha`, `total_Venta`) VALUES
(1, 7, 2, '2024-02-09', 99.50),
(2, 11, 2, '2024-01-18', 71.90),
(3, 12, 2, '2024-01-24', 192.00),
(4, 10, 2, '2024-04-27', 191.90),
(5, 6, 2, '2024-04-27', 126.00),
(6, 9, 2, '2024-02-23', 128.00),
(7, 8, 2, '2024-02-21', 125.00),
(8, 10, 2, '2024-05-06', 80.00),
(9, 4, 2, '2024-05-06', 114.00),
(10, 11, 2, '2024-05-06', 141.50),
(11, 7, 2, '2024-03-22', 397.50),
(12, 5, 2, '2024-05-06', 146.00),
(13, 9, 2, '2024-05-06', 59.00),
(14, 10, 2, '2024-05-06', 13.50),
(15, 5, 2, '2024-05-16', 32.20),
(16, 3, 2, '2024-05-16', 60.50);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`ID_Categoria`);

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`ID_Cliente`);

--
-- Indices de la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  ADD PRIMARY KEY (`ID_Detalle`),
  ADD KEY `ID_Venta` (`ID_Venta`),
  ADD KEY `ID_Farmaco` (`ID_Farmaco`);

--
-- Indices de la tabla `farmaco`
--
ALTER TABLE `farmaco`
  ADD PRIMARY KEY (`ID_Farmaco`),
  ADD KEY `ID_Categoria` (`ID_Categoria`),
  ADD KEY `ID_Proveedor` (`ID_Proveedor`);

--
-- Indices de la tabla `personal`
--
ALTER TABLE `personal`
  ADD PRIMARY KEY (`ID_Personal`);

--
-- Indices de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  ADD PRIMARY KEY (`ID_Proveedor`);

--
-- Indices de la tabla `venta`
--
ALTER TABLE `venta`
  ADD PRIMARY KEY (`ID_Venta`),
  ADD KEY `ID_Personal` (`ID_Personal`),
  ADD KEY `ID_Cliente` (`ID_Cliente`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `ID_Categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `ID_Cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  MODIFY `ID_Detalle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT de la tabla `farmaco`
--
ALTER TABLE `farmaco`
  MODIFY `ID_Farmaco` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `personal`
--
ALTER TABLE `personal`
  MODIFY `ID_Personal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  MODIFY `ID_Proveedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `venta`
--
ALTER TABLE `venta`
  MODIFY `ID_Venta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  ADD CONSTRAINT `detalle_venta_ibfk_1` FOREIGN KEY (`ID_Venta`) REFERENCES `venta` (`ID_Venta`),
  ADD CONSTRAINT `detalle_venta_ibfk_2` FOREIGN KEY (`ID_Farmaco`) REFERENCES `farmaco` (`ID_Farmaco`);

--
-- Filtros para la tabla `farmaco`
--
ALTER TABLE `farmaco`
  ADD CONSTRAINT `farmaco_ibfk_1` FOREIGN KEY (`ID_Categoria`) REFERENCES `categoria` (`ID_Categoria`),
  ADD CONSTRAINT `farmaco_ibfk_2` FOREIGN KEY (`ID_Proveedor`) REFERENCES `proveedor` (`ID_Proveedor`);

--
-- Filtros para la tabla `venta`
--
ALTER TABLE `venta`
  ADD CONSTRAINT `venta_ibfk_1` FOREIGN KEY (`ID_Personal`) REFERENCES `personal` (`ID_Personal`),
  ADD CONSTRAINT `venta_ibfk_2` FOREIGN KEY (`ID_Cliente`) REFERENCES `cliente` (`ID_Cliente`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
