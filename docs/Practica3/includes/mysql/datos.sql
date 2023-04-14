
TRUNCATE TABLE `Usuarios`;
TRUNCATE TABLE `Vinilos`;
TRUNCATE TABLE `Artistas`;
TRUNCATE TABLE `Comentarios`;
TRUNCATE TABLE `Compras`;
TRUNCATE TABLE `Canciones`;
TRUNCATE TABLE `Seguidos`;
TRUNCATE TABLE `Eventos`;

INSERT INTO `Usuarios` (`username`, `password`, `nombre`,`correo`,`rol`) VALUES
('user1', 'user1pass', 'Juan', 'juan@gmail.com', 'usuario'),
('user2', 'user2pass', 'Maria', 'maria@gmail.com', 'usuario'),
('user3', 'user3pass', 'Jose', 'jose@gmail.com', 'usuario'),
('user4', 'user4pass', 'Lucia', 'lucia@gmail.com', 'usuario'),
('admin', 'adminpass', 'Fernando', 'admin@gmail.com', 'admin');

INSERT INTO `Vinilos` (`id`, `titulo`, `autor`, `idAutor`, `precio`, `portada`, `ventas`, `stock`) VALUES 
(1, 'The Dark Side Of The Moon', 'Pink Floyd', 1, 50, 'img/portadas/id1.jpg', 0, 30),
(2, 'Motomami', 'Rosalia', 2, 35, 'img/portadas/id2.jpg', 0, 30),
(3, 'Nevermind', 'Nirvana', 3, 40, 'img/portadas/id3.jpg', 0, 30),
(4, 'El Mal Querer', 'Rosalia', 2, 40, 'img/portadas/id4.jpg', 0, 30),
(5, 'Donde Quiero Estar', 'Quevedo', 4, 30, 'img/portadas/id5.jpg', 0, 30);

INSERT INTO `Artistas` (`id`, `nombre`, `seguidores`, `eventos`, `foto`) VALUES
(1, 'Pink Floyd', 0, NULL, 'img/artistas/pinkfloyd.png'),
(2, 'Rosalía', 0, NULL, 'img/artistas/rosalia.png'),
(3, 'Nirvana', 0, NULL, 'img/artistas/nirvana.png'),
(4, "Quevedo", 0, NULL, 'img/artistas/quevedo.png');

INSERT INTO `Comentarios` (`id`,`vinilo_id`,`autor`,`comentario`,`fecha`,`padre`) VALUES
(1, 2, 'user1', 'Muy buen disco', @INICIO, NULL),
(2, 2, 'user3', 'Estoy de acuerdo', ADDTIME(@INICIO, '0:10:0'),1);

INSERT INTO `Compras`(`id`, `user`, `idVinilo`, `precio`, `enCesta`, `comprado`, `fechaCompra`) VALUES 
(1, 'user1', 2, 30, true, false, '2023-02-10'),
(2, 'user1', 3, 30, true, false, '2023-02-10');

INSERT INTO `Canciones` (`idVinilo`, `titulo`, `audio`) VALUES 
(1, 'Speak to Me', 'audio/prueba-audio.mp3'),
(1, 'Breathe', 'audio/prueba-audio.mp3'),
(1, 'On the Run', 'audio/prueba-audio.mp3'),
(1, 'Time', 'audio/prueba-audio.mp3'),
(1, 'The Great Gig in the Sky', 'audio/prueba-audio.mp3'),
(1, 'Money', 'audio/prueba-audio.mp3'),
(1, 'Us and Them', 'audio/prueba-audio.mp3'),
(1, 'Any Colour You Like', 'audio/prueba-audio.mp3'),
(1, 'Brain Damage', 'audio/prueba-audio.mp3'),
(1, 'Eclipse', 'audio/prueba-audio.mp3'),
(2, 'SAOKO', 'audio/prueba-audio.mp3'),
(2, 'CANDY', 'audio/prueba-audio.mp3'),
(2, 'LA FAMA', 'audio/prueba-audio.mp3'),
(2, 'BULERÍAS', 'audio/prueba-audio.mp3'),
(2, 'CHICKEN TERIYAKI', 'audio/prueba-audio.mp3'),
(2, 'HENTAI', 'audio/prueba-audio.mp3'),
(2, 'BIZCOCHITO', 'audio/prueba-audio.mp3'),
(2, 'G3 N15', 'audio/prueba-audio.mp3'),
(2, 'MOTOMAMI', 'audio/prueba-audio.mp3'),
(2, 'DIABLO', 'audio/prueba-audio.mp3'),
(2, 'DELIRIO DE GRANDEZA', 'audio/prueba-audio.mp3'),
(2, 'CUUUUuuuuuute', 'audio/prueba-audio.mp3'),
(2, 'COMO UN G', 'audio/prueba-audio.mp3'),
(2, 'Abcdefg', 'audio/prueba-audio.mp3'),
(2, 'LA COMBI VERSACE', 'audio/prueba-audio.mp3'),
(2, 'SAKURA', 'audio/prueba-audio.mp3'),
(3, 'Smells Like Teen Spirit', 'audio/prueba-audio.mp3'),
(3, 'In Bloom', 'audio/prueba-audio.mp3'),
(3, 'Come as You Are', 'audio/prueba-audio.mp3'),
(3, 'Breed', 'audio/prueba-audio.mp3'),
(3, 'Lithium', 'audio/prueba-audio.mp3'),
(3, 'Polly', 'audio/prueba-audio.mp3'),
(3, 'Territorial Pissings', 'audio/prueba-audio.mp3'),
(3, 'Drain You', 'audio/prueba-audio.mp3'),
(3, 'Lounge Act', 'audio/prueba-audio.mp3'),
(3, 'Stay Away', 'audio/prueba-audio.mp3'),
(3, 'On a Plain', 'audio/prueba-audio.mp3'),
(3, 'Something in the Way', 'audio/prueba-audio.mp3'),
(3, 'Endless, Nameless', 'audio/prueba-audio.mp3'),
(4, 'MALAMENTE (Cap.1: Augurio)', 'audio/prueba-audio.mp3'),
(4, 'QUE NO SALGA LA LUNA (Cap.2: Boda)', 'audio/prueba-audio.mp3'),
(4, 'PIENSO EN TU MIRÁ (Cap.3: Celos)', 'audio/prueba-audio.mp3'),
(4, 'DE AQUÍ NO SALES (Cap.4: Disputa)', 'audio/prueba-audio.mp3'),
(4, 'RENIEGO (Cap.5: Lamento)', 'audio/prueba-audio.mp3'),
(4, 'PRESO (Cap.6: Clausura)', 'audio/prueba-audio.mp3'),
(4, 'BAGDAD (Cap.7: Liturgia)', 'audio/prueba-audio.mp3'),
(4, 'DI MI NOMBRE (Cap.8: Éxtasis)', 'audio/prueba-audio.mp3'),
(4, 'NANA (Cap.9: Concepción)', 'audio/prueba-audio.mp3'),
(4, 'MALDICIÓN (Cap.10: Cordura)', 'audio/prueba-audio.mp3'),
(4, 'A NINGÚN HOMBRE (Cap.11: Poder)', 'audio/prueba-audio.mp3'),
(5, 'INTRO - SPEECH CRUZZI', 'audio/prueba-audio.mp3'),
(5, 'AHORA QUÉ', 'audio/prueba-audio.mp3'),
(5, 'YANKEE', 'audio/prueba-audio.mp3'),
(5, 'VISTA AL MAR', 'audio/prueba-audio.mp3'),
(5, 'PLAYA DEL INGLÉS', 'audio/prueba-audio.mp3'),
(5, 'SIN SEÑAL', 'audio/prueba-audio.mp3'),
(5, 'DAME', 'audio/prueba-audio.mp3'),
(5, 'CUÉNTALE', 'audio/prueba-audio.mp3'),
(5, 'LUCES AZULES', 'audio/prueba-audio.mp3'),
(5, 'PUNTO G', 'audio/prueba-audio.mp3'),
(5, 'MUÑECA', 'audio/prueba-audio.mp3'),
(5, 'WANDA', 'audio/prueba-audio.mp3'),
(5, 'ME FALTA ALGO', 'audio/prueba-audio.mp3'),
(5, 'LISBOA', 'audio/prueba-audio.mp3'),
(5, 'ÉRAMOS DOS', 'audio/prueba-audio.mp3'),
(5, 'DONDE QUIERO ESTAR', 'audio/prueba-audio.mp3');

INSERT INTO `Eventos` (`fecha`, `idArtista`, `tipo`, `descripcion`) VALUES
('2023-04-29', 2, 'disco', NULL),
('2023-04-14', 1, 'concierto', 'Concierto en Madrid a las 22:00');