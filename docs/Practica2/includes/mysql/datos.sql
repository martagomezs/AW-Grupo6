TRUNCATE TABLE `Usuarios`;
TRUNCATE TABLE `Vinilos`;
TRUNCATE TABLE `Artistas`;
TRUNCATE TABLE `Comentarios`;
TRUNCATE TABLE `Compras`;
TRUNCATE TABLE `Canciones`;
TRUNCATE TABLE `Discografia`;
TRUNCATE TABLE `Seguidos`;

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
(3, 'Endless, Nameless', 'audio/prueba-audio.mp3');

INSERT INTO `Discografia` (`idArtista`, `idVinilo`) VALUES 
(1, 1),
(2, 2),
(3, 3);

