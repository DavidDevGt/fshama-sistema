-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 14-09-2023 a las 00:48:46
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
-- Base de datos: `inventario_fshama_v2`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id_categoria` int(11) NOT NULL,
  `nombre_categoria` varchar(255) NOT NULL,
  `descripcion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id_categoria`, `nombre_categoria`, `descripcion`) VALUES
(1, 'PINTURA', 'Pintura de agua, aceite, anticorrosivo, en aerosol, etc.'),
(2, 'CONSTRUCCION', 'Cemento, cal, arena, piedrín, etc.'),
(3, 'MATERIAL ELÉCTRICO', 'Tomacorrientes, cable eléctrico, apagadores, etc.'),
(4, 'AISLANTES', 'Cintas aislantes, protectores, etc.'),
(5, 'HERRERIA', 'Careta p/soldar, electrodo, etc.'),
(6, 'TUBERIA PVC', 'Tubo potable, tubo drenaje, etc.'),
(7, 'GRIFERIA', 'Chorros, llaves de compuerta, llaves de globo, etc.'),
(8, 'LIJAS', 'Lija de lona, de agua, discos de lija, etc.'),
(9, 'HERRAMIENTAS MANUALES', 'Martillos, destornilladores, alicates, etc.'),
(10, 'HERRAMIENTAS ELÉCTRICAS', 'Taladros, sierras eléctricas, pulidoras, etc.'),
(11, 'SEGURIDAD', 'Cascos, guantes, lentes de seguridad, etc.'),
(12, 'JARDINERÍA', 'Herramientas de jardín, semillas, abonos, etc.'),
(13, 'FERRETERÍA GENERAL', 'Tornillos, clavos, tuercas, grapas etc.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalles_factura_compra`
--

CREATE TABLE `detalles_factura_compra` (
  `id_detalle` int(11) NOT NULL,
  `id_factura` int(11) DEFAULT NULL,
  `id_producto` int(11) DEFAULT NULL,
  `cantidad_comprada` int(11) NOT NULL,
  `precio_unitario_compra` decimal(10,2) NOT NULL,
  `subtotal_compra` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalles_pedido_venta`
--

CREATE TABLE `detalles_pedido_venta` (
  `id_detalle_venta` int(11) NOT NULL,
  `id_pedido` int(11) DEFAULT NULL,
  `id_producto` int(11) DEFAULT NULL,
  `cantidad_vendida` int(11) NOT NULL,
  `precio_unitario_venta` decimal(10,2) NOT NULL,
  `subtotal_venta` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facturas_compra`
--

CREATE TABLE `facturas_compra` (
  `id_factura` int(11) NOT NULL,
  `id_proveedor` int(11) DEFAULT NULL,
  `fecha_compra` date NOT NULL,
  `total_compra` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventario`
--

CREATE TABLE `inventario` (
  `id_inventario` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp(),
  `tipo_movimiento` enum('Entrada','Salida') NOT NULL,
  `cantidad` int(11) NOT NULL,
  `motivo` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos_venta`
--

CREATE TABLE `pedidos_venta` (
  `id_pedido` int(11) NOT NULL,
  `fecha_venta` date NOT NULL,
  `total_venta` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id_producto` int(11) NOT NULL,
  `nombre_producto` varchar(255) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `id_categoria` int(11) DEFAULT NULL,
  `precio_compra` decimal(10,2) NOT NULL,
  `precio_venta` decimal(10,2) NOT NULL,
  `stock_actual` int(11) NOT NULL DEFAULT 0,
  `unidad_medida` enum('Unidad','Metro','Libra','Litro','Yarda','Galon','Ciento','Saco') NOT NULL,
  `active` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id_producto`, `nombre_producto`, `descripcion`, `id_categoria`, `precio_compra`, `precio_venta`, `stock_actual`, `unidad_medida`, `active`) VALUES
(1, 'Tornillo 4x40', 'Tornillo de acero inoxidable, 4x40mm', 4, 0.10, 0.25, 500, 'Unidad', 1),
(2, 'Tornillo 4x50', 'Tornillo de acero inoxidable, 4x50mm', 4, 0.12, 0.30, 400, 'Unidad', 1),
(3, 'Pintura Roja', 'Lata de pintura roja 1 galón', 3, 20.00, 35.00, 25, 'Galon', 1),
(4, 'Cemento Portland', 'Saco de cemento 50kg', 5, 8.00, 12.00, 30, 'Saco', 1),
(5, 'Llave Ajustable 8\"', 'Llave ajustable 8\"', 4, 12.00, 20.00, 50, 'Unidad', 1),
(6, 'Llave Ajustable 10\"', 'Llave ajustable 10\"', 4, 15.00, 25.00, 40, 'Unidad', 1),
(7, 'Llave Ajustable 12\"', 'Llave ajustable 12\"', 4, 18.00, 30.00, 35, 'Unidad', 1),
(8, 'Broca para Madera 6mm', 'Broca para madera 6mm', 2, 2.50, 5.00, 100, 'Unidad', 1),
(9, 'Broca para Madera 8mm', 'Broca para madera 8mm', 2, 3.00, 6.50, 80, 'Unidad', 1),
(10, 'Broca para Madera 10mm', 'Broca para madera 10mm', 2, 3.50, 7.50, 70, 'Unidad', 1),
(11, 'Destornillador Plano', 'Destornillador plano 6\"', 4, 4.00, 7.00, 60, 'Unidad', 1),
(12, 'Destornillador Estrella', 'Destornillador estrella 6\"', 4, 4.00, 7.00, 65, 'Unidad', 1),
(13, 'Escalera de Aluminio 6 Peldaños', 'Escalera de aluminio 6 peldaños', 6, 100.00, 150.00, 15, 'Unidad', 1),
(14, 'Escalera de Aluminio 8 Peldaños', 'Escalera de aluminio 8 peldaños', 6, 120.00, 180.00, 12, 'Unidad', 1),
(15, 'Cable Eléctrico 2.5mm', 'Cable eléctrico 2.5mm, rollo 100 metros', 7, 50.00, 75.00, 10, 'Unidad', 1),
(16, 'Cable Eléctrico 4mm', 'Cable eléctrico 4mm, rollo 100 metros', 7, 70.00, 100.00, 8, 'Unidad', 1),
(17, 'Serrucho para Madera 16\"', 'Serrucho para madera 16\"', 2, 7.00, 12.00, 40, 'Unidad', 1),
(18, 'Serrucho para Metal 12\"', 'Serrucho para metal 12\"', 2, 8.00, 14.00, 35, 'Unidad', 1),
(19, 'Cinta de Teflón', 'Rollo cinta de teflón para tuberías', 8, 1.50, 3.00, 90, 'Unidad', 1),
(20, 'Sierra Circular', 'Sierra circular 7.25\"', 2, 90.00, 150.00, 18, 'Unidad', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE `proveedores` (
  `id_proveedor` int(11) NOT NULL,
  `nombre_proveedor` varchar(255) NOT NULL,
  `direccion` text DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `dias_vencimiento_factura` enum('15','30','60') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Indices de la tabla `detalles_factura_compra`
--
ALTER TABLE `detalles_factura_compra`
  ADD PRIMARY KEY (`id_detalle`),
  ADD KEY `id_factura` (`id_factura`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `detalles_pedido_venta`
--
ALTER TABLE `detalles_pedido_venta`
  ADD PRIMARY KEY (`id_detalle_venta`),
  ADD KEY `id_pedido` (`id_pedido`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `facturas_compra`
--
ALTER TABLE `facturas_compra`
  ADD PRIMARY KEY (`id_factura`),
  ADD KEY `id_proveedor` (`id_proveedor`);

--
-- Indices de la tabla `inventario`
--
ALTER TABLE `inventario`
  ADD PRIMARY KEY (`id_inventario`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `pedidos_venta`
--
ALTER TABLE `pedidos_venta`
  ADD PRIMARY KEY (`id_pedido`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id_producto`),
  ADD KEY `id_categoria` (`id_categoria`);

--
-- Indices de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`id_proveedor`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `detalles_factura_compra`
--
ALTER TABLE `detalles_factura_compra`
  MODIFY `id_detalle` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detalles_pedido_venta`
--
ALTER TABLE `detalles_pedido_venta`
  MODIFY `id_detalle_venta` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `facturas_compra`
--
ALTER TABLE `facturas_compra`
  MODIFY `id_factura` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `inventario`
--
ALTER TABLE `inventario`
  MODIFY `id_inventario` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pedidos_venta`
--
ALTER TABLE `pedidos_venta`
  MODIFY `id_pedido` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  MODIFY `id_proveedor` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `detalles_factura_compra`
--
ALTER TABLE `detalles_factura_compra`
  ADD CONSTRAINT `detalles_factura_compra_ibfk_1` FOREIGN KEY (`id_factura`) REFERENCES `facturas_compra` (`id_factura`),
  ADD CONSTRAINT `detalles_factura_compra_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`);

--
-- Filtros para la tabla `detalles_pedido_venta`
--
ALTER TABLE `detalles_pedido_venta`
  ADD CONSTRAINT `detalles_pedido_venta_ibfk_1` FOREIGN KEY (`id_pedido`) REFERENCES `pedidos_venta` (`id_pedido`),
  ADD CONSTRAINT `detalles_pedido_venta_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`);

--
-- Filtros para la tabla `facturas_compra`
--
ALTER TABLE `facturas_compra`
  ADD CONSTRAINT `facturas_compra_ibfk_1` FOREIGN KEY (`id_proveedor`) REFERENCES `proveedores` (`id_proveedor`);

--
-- Filtros para la tabla `inventario`
--
ALTER TABLE `inventario`
  ADD CONSTRAINT `inventario_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`);

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id_categoria`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
