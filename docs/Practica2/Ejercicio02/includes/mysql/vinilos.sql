
CREATE TABLE IF NOT EXISTS `vinilos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(50) COLLATE utf8mb4_general_ci NOT NULL UNIQUE,
  `autor` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `pistas` TEXT,
  `muestra_audio` TEXT,
  `portada` VARCHAR(255) NOT NULL;
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO vinilos (id, titulo, autor, pistas, muestra_audio, portada)
VALUES ('1', 'The Dark Side Of The Moon', 'Pink Floyd','Speak To Me, Breathe, Time', 'https://ejemplo.com/audio.mp3', 'portadas/id1.jpg');

INSERT INTO vinilos (id, titulo, autor, pistas, muestra_audio, portada)
VALUES ('2', 'Motomami', 'Rosalía','Saoko, La Fama', 'https://ejemplo.com/audio.mp3', 'portadas/id2.jpg');

INSERT INTO vinilos (id, titulo, autor, pistas, muestra_audio, portada)
VALUES ('3', 'Nevermind', 'Nirvana','In Bloom, Breed, Lithium', 'https://ejemplo.com/audio.mp3', 'portadas/id3.jpg');
