
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
