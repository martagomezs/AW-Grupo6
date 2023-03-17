TRUNCATE TABLE `Usuarios`;
TRUNCATE TABLE `Vinilos`;
TRUNCATE TABLE `Artistas`;
TRUNCATE TABLE `Comentarios`;
TRUNCATE TABLE `Compras`;

INSERT INTO `Usuarios` (`username`, `password`, `nombre`,`correo`,`rol`,`ventas`) VALUES
('user1', 'user1pass', 'Juan', 'juan@gmail.com', 'usuario', NULL),
('user2', 'user2pass', 'Maria', 'maria@gmail.com', 'usuario', NULL),
('user3', 'user3pass', 'Jose', 'jose@gmail.com', 'usuario', NULL),
('user4', 'user4pass', 'Lucia', 'lucia@gmail.com', 'usuario', NULL);

INSERT INTO `vinilos` (`id`, `titulo`, `autor`, `idAutor`, `precio`, `canciones`, `portada`, `ventas`) VALUES 
(1, 'The Dark Side Of The Moon', 'Pink Floyd', 1, 50, 'audio/prueba-audio.mp3', 'img/portadas/id1.jpg', 0),
(2, 'Motomami', 'Rosalia', 2, 35, 'audio/prueba-audio.mp3', 'img/portadas/id2.jpg', 0),
(3, 'Nevermind', 'Nirvana', 3, 40, 'audio/prueba-audio.mp3', 'img/portadas/id3.jpg', 0);

INSERT INTO `Artistas` (`id`, `nombre`, `vinilo`, `seguidores`, `eventos`, `foto`) VALUES
(1, 'Pink Floyd', 1, 0, NULL, 'img/artistas/pinkfloyd.png'),
(2, 'Rosalía', 2, 0, NULL, 'img/artistas/rosalia.png'),
(3, 'Nirvana', 3, 0, NULL, 'img/artistas/nirvana.png');

INSERT INTO `Comentarios` (`id`,`vinilo_id`,`autor`,`comentario`,`fecha`,`padre`) VALUES
(1, 2, 'user1', 'Muy buen disco', @INICIO, NULL),
(2, 2, 'user3', 'Estoy de acuerdo', ADDTIME(@INICIO, '0:10:0'),1);

INSERT INTO `Compras`(`User`,`IdVinilo`, `compra`) VALUES ('user1',2, false);

