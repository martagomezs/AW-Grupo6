

INSERT INTO `Usuarios` (`id`, `password`, `Ntarjeta`,`Nombre`,`Correo`,`Rol`,`Ventas`) VALUES
(1, 'userpass', '1234567898765432', 'Usuario', 'user@usuario.com', 'usuario', NULL),
(2, 'adminpass', '1357975313579753', 'Administrador', 'admin@administrador.com', 'admin', NULL),
(3, 'rosi', '9876543212345678', 'Rosalia', 'moto@mami.es', 'artista', 1),
(4, 'pink', '2468086424680864', 'Pink Floyd', 'pink@floyd.com', 'artista', 0),
(5, 'nirvpass', '1111111111111111', 'Nirvana', 'nirvana@never.com', 'artista', 0);

INSERT INTO `vinilos` (`id`, `titulo`, `autor`, `precio`, `canciones`, `portada`) VALUES 
(1, 'The Dark Side Of The Moon', 4, 50, 'https://ejemplo.com/audio.mp3', 'portadas/id1.jpg'),
(2, 'Motomami', 3, 35, 'https://ejemplo.com/audio.mp3', 'portadas/id2.jpg'),
(3, 'Nevermind', 5, 40, 'https://ejemplo.com/audio.mp3', 'portadas/id3.jpg');

INSERT INTO `Comentarios` (`id`,`vinilo_id`,`autor`,`comentario`,`fecha`,`padre`) VALUES
(1, 2, 1, 'Muy buen disco', @INICIO, NULL),
(2, 2, 3, 'Muchas gracias!!', ADDTIME(@INICIO, '0:10:0'),1);

INSERT INTO `Compras`(`Id-User`,`Id-Vinilo`) VALUES (1,2);
