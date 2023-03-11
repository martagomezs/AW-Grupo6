/*
  Recuerda que deshabilitar la opción "Enable foreign key checks" para evitar problemas a la hora de importar el script.
*/
TRUNCATE TABLE `RolesUsuario`;
TRUNCATE TABLE `Roles`;
TRUNCATE TABLE `Usuarios`;
TRUNCATE TABLE `Mensajes`;

INSERT INTO `Roles` (`id`, `nombre`) VALUES
(1, 'admin'),
(2, 'user');


INSERT INTO `RolesUsuario` (`usuario`, `rol`) VALUES
(1, 1),
(1, 2),
(2, 2);

/*
  user: userpass
  admin: adminpass
*/
INSERT INTO `Usuarios` (`id`, `nombreUsuario`, `nombre`, `password`) VALUES
(1, 'admin', 'Administrador', '$2y$10$O3c1kBFa2yDK5F47IUqusOJmIANjHP6EiPyke5dD18ldJEow.e0eS'),
(2, 'user', 'Usuario', '$2y$10$uM6NtF.f6e.1Ffu2rMWYV.j.X8lhWq9l8PwJcs9/ioVKTGqink6DG');

SET @INICIO := NOW();
INSERT INTO `Mensajes` (`id`, `autor`, `mensaje`, `fechaHora`, `idMensajePadre`) VALUES
(1, 1, 'Bienvenido al foro', @INICIO, NULL),
(2, 2, 'Muchas gracias', ADDTIME(@INICIO, '0:15:0'), 1),
(3, 2, 'Otro mensaje', ADDTIME(@INICIO, '25:15:0'), NULL);

/*
  VINILOS
*/
INSERT INTO vinilos (id, titulo, autor, pistas, muestra_audio, portada)
VALUES ('1', 'The Dark Side Of The Moon', 'Pink Floyd','Speak To Me, Breathe, Time', 'https://ejemplo.com/audio.mp3', 'portadas/id1.jpg');

INSERT INTO vinilos (id, titulo, autor, pistas, muestra_audio, portada)
VALUES ('2', 'Motomami', 'Rosalía','Saoko, La Fama', 'https://ejemplo.com/audio.mp3', 'portadas/id2.jpg');

INSERT INTO vinilos (id, titulo, autor, pistas, muestra_audio, portada)
VALUES ('3', 'Nevermind', 'Nirvana','In Bloom, Breed, Lithium', 'https://ejemplo.com/audio.mp3', 'portadas/id3.jpg');
