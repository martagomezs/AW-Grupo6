

INSERT INTO `Usuarios` (`username`, `password`, `nombre`,`correo`,`rol`,`ventas`) VALUES
('user1', 'user1pass', 'Juan', 'juan@gmail.com', 'usuario', NULL),
('user2', 'user2pass', 'Maria', 'maria@gmail.com', 'usuario', NULL),
('user3', 'user3pass', 'Jose', 'jose@gmail.com', 'usuario', NULL),
('user4', 'user4pass', 'Lucia', 'lucia@gmail.com', 'usuario', NULL);

-- INSERT INTO `vinilos` (`id`, `titulo`, `autor`, `precio`, `canciones`, `portada`) VALUES 
-- (1, 'The Dark Side Of The Moon', 4, 50, 'https://ejemplo.com/audio.mp3', 'portadas/id1.jpg'),
-- (2, 'Motomami', 3, 35, 'https://ejemplo.com/audio.mp3', 'portadas/id2.jpg'),
-- (3, 'Nevermind', 5, 40, 'https://ejemplo.com/audio.mp3', 'portadas/id3.jpg');

-- INSERT INTO `Comentarios` (`id`,`vinilo_id`,`autor`,`comentario`,`fecha`,`padre`) VALUES
-- (1, 2, 1, 'Muy buen disco', @INICIO, NULL),
-- (2, 2, 3, 'Muchas gracias!!', ADDTIME(@INICIO, '0:10:0'),1);

-- INSERT INTO `Compras`(`Id-User`,`Id-Vinilo`) VALUES (1,2);
