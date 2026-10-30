
CREATE TABLE `roles` (
  `id` integer PRIMARY KEY AUTO_INCREMENT,
  `rol` varchar(50) NOT NULL UNIQUE
);

CREATE TABLE `usuarios` (
  `id` integer PRIMARY KEY AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `id_rol` integer NOT NULL,
  `correo` varchar(255) UNIQUE NOT NULL,
  `password` varchar(255) NOT NULL
);

CREATE TABLE `categorias` (
  `id` integer PRIMARY KEY AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL UNIQUE
);

CREATE TABLE `productos` (
  `id` integer PRIMARY KEY AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `descripcion` text,
  `id_categoria` integer NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `existencias` integer NOT NULL DEFAULT 0,
  `foto` varchar(255),
  `destacado` boolean NOT NULL DEFAULT FALSE
);

CREATE TABLE `marcas_vehiculos` (
  `id` integer PRIMARY KEY AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `logo` varchar(255)
); 

CREATE TABLE `tipos_vehiculos` (
  `id` integer PRIMARY KEY AUTO_INCREMENT,
  `tipo` varchar(255) NOT NULL
);

CREATE TABLE `marcas_aceite` (
  `id` integer PRIMARY KEY AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL
);

CREATE TABLE `kit_base` (
  `id` integer PRIMARY KEY AUTO_INCREMENT,
  `id_tipo_vehiculo` integer NOT NULL,
  `id_marca_aceite` integer NOT NULL,
  `id_marca_vehiculo` integer NOT NULL,
  `viscosidad_aceite` varchar(255) NOT NULL,
  `precio` decimal(10,2) NOT NULL
);

CREATE TABLE `kit_extras` (
  `id` integer PRIMARY KEY AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `grupo` varchar(255) NOT NULL,
  `costo` decimal(10,2) NOT NULL
);

CREATE TABLE `facturas` (
  `id` integer PRIMARY KEY AUTO_INCREMENT,
  `id_usuario` integer NOT NULL,
  `numero_factura` varchar(30) NOT NULL UNIQUE,
  `fecha` datetime NOT NULL,
  `nombre_cliente` varchar(255) NOT NULL,
  `rtn` varchar(14) NOT NULL,
  `telefono` varchar(8) NOT NULL,
  `direccion_envio` varchar(255) NOT NULL,
  `modalidad_envio` varchar(30) NOT NULL,
  `sub_total` decimal(10,2) NOT NULL,
  `descuento` decimal(10,2) NOT NULL DEFAULT 0,
  `isv` decimal(10,2) NOT NULL,
  `costo_envio` decimal(10,2) NOT NULL DEFAULT 0,
  `total` decimal(10,2) NOT NULL
);

CREATE TABLE `detalle_factura` (
  `id` integer PRIMARY KEY AUTO_INCREMENT,
  `id_factura` integer NOT NULL,
  `id_producto` integer NULL,
  `descripcion` varchar(255) NOT NULL,
  `cantidad` integer NOT NULL,
  `precio_unitario` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL
);

ALTER TABLE `usuarios` ADD FOREIGN KEY (`id_rol`) REFERENCES `roles` (`id`);
ALTER TABLE `facturas` ADD FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`);
ALTER TABLE `productos` ADD FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id`);
ALTER TABLE `detalle_factura` ADD FOREIGN KEY (`id_factura`) REFERENCES `facturas` (`id`);
ALTER TABLE `detalle_factura` ADD FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id`);
ALTER TABLE `kit_base` ADD FOREIGN KEY (`id_tipo_vehiculo`) REFERENCES `tipos_vehiculos` (`id`);
ALTER TABLE `kit_base` ADD FOREIGN KEY (`id_marca_aceite`) REFERENCES `marcas_aceite` (`id`);
ALTER TABLE `kit_base` ADD FOREIGN KEY (`id_marca_vehiculo`) REFERENCES `marcas_vehiculos` (`id`);
