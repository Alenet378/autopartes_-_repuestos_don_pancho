
INSERT INTO `categorias` (`id`, `nombre`) VALUES
(4, 'Fluidos y Lubricantes'),
(1, 'Frenos y Suspension'),
(2, 'Motor y Transmision'),
(3, 'Sistema Electrico');



INSERT INTO `productos` (`id`, `nombre`, `descripcion`, `id_categoria`, `precio`, `existencias`, `foto`, `destacado`) VALUES
(1, 'Aceite', 'Aceite para vehiculos', 4, 850.00, 15, 'aceite.jpg', 1),
(2, 'Bujia', 'Bujía de encendido con electrodo de iridio', 2, 250.00, 30, 'bujias.jpg', 1),
(3, 'Filtro de Aceite', 'Es un componente esencial del sistema de lubricación cuyo propósito es retener impurezas', 4, 180.00, 25, 'filtro_de_aceite.jpg', 1),
(4, 'Liquido de Frenos', 'Fluido hidráulico esencial que transmite la fuerza que ejerces sobre el pedal de freno hacia las ruedas para detener el vehículo.', 4, 650.00, 15, 'frenos.jpg', 1),
(5, 'Limpiador de Inyectores', 'Aditivo químico o equipo mecánico diseñado para eliminar los depósitos de carbón, barniz y suciedad que se acumulan en los inyectores de combustible', 2, 180.00, 18, 'limpiador.jpg', 1),
(6, 'Pastillas de Freno', 'Componentes esenciales del sistema de frenado de disco que generan fricción contra el rotor metálico para detener el vehículo', 1, 700.00, 23, 'pastillas.jpg', 0),
(7, 'Refrigerante', 'Fluido vital que circula por el motor para regular su temperatura, evitar el sobrecalentamiento en climas cálidos y proteger los componentes internos contra la corrosión', 3, 1250.00, 35, 'refrigerante.jpg', 0);



INSERT INTO `roles` (`id`, `rol`) VALUES
(1, 'Admin'),
(2, 'Bodega'),
(3, 'Usuario');


INSERT INTO `usuarios` (`id`, `username`, `id_rol`, `correo`, `password`) VALUES
(1, 'Alejandro', 1, 'alejo@gmail.com', '12345'),
(2, 'Frixon', 2, 'frixon@gmail.com', '12345'),
(3, 'Paco', 3, 'paco@gmail.com', '12345');


INSERT INTO `marcas_vehiculos` (`id`, `nombre`,`logo`) VALUES
(1, 'Ford','ford.jpg'),
(2, 'Honda','honda.jpg'),
(3, 'Hyundai','hyndai.jpg'),
(4, 'Isuzu','isuzu.jpg'),
(5, 'Nissan','nissan.jpg'),
(6, 'Toyota','toyota.jpg');

INSERT INTO filtros (`nombre`, `descripcion`,`precio`,`existencias`) VALUES
('Filtro de aceite', 'Filtra impurezas del aceite del motor', 180.00, 25),
('Filtro de aire', 'Filtra el aire que ingresa al motor', 220.00, 20),
('Filtro de combustible', 'Retiene impurezas del combustible', 250.00, 15),
('Filtro de cabina', 'Filtra el aire del sistema de ventilación', 200.00, 18);

INSERT INTO kit_extras (nombre, grupo, costo) VALUES
('Bujías de iridio', 'Encendido', 450.00),
('Pastillas cerámicas', 'Frenos', 650.00),
('Limpiador de inyectores', 'Limpieza', 180.00),
('Líquido de frenos', 'Fluidos', 250.00),
('Refrigerante', 'Fluidos', 220.00);

INSERT INTO marcas_aceite (nombre) VALUES
('Castrol'),
('Mobil 1'),
('Shell Helix'),
('Valvoline'),
('Motul'),
('TotalEnergies');

INSERT INTO tipos_vehiculos (tipo) VALUES
('Sedán'),
('SUV'),
('Pick-Up 4x4');

INSERT INTO kit_base (
    id_tipo_vehiculo,
    id_marca_aceite,
    id_marca_vehiculo,
    viscosidad_aceite,
    precio
    ) VALUES
(1, 1, 2, '5W-30', 1200.00),
(1, 2, 5, '10W-30', 1250.00),
(1, 3, 3, '5W-40', 1180.00),
(1, 4, 1, '10W-40', 1150.00),
(2, 1, 6, '5W-30', 1450.00),
(2, 2, 2, '5W-40', 1500.00),
(2, 3, 5, '10W-40', 1400.00),
(2, 5, 3, '5W-40', 1550.00),
(3, 1, 1, '15W-40', 1750.00),
(3, 2, 6, '10W-40', 1800.00),
(3, 4, 4, '15W-40', 1700.00),
(3, 6, 4, '5W-40', 1850.00);