
/*
  Recuerda que deshabilitar la opción "Enable foreign key checks" para evitar problemas a la hora de importar el script.
*/
DROP TABLE IF EXISTS `Usuarios`;
DROP TABLE IF EXISTS `Artista`;
DROP TABLE IF EXISTS `Vinilos`;
DROP TABLE IF EXISTS `Comentarios`;
DROP TABLE IF EXISTS `Compras`;

CREATE TABLE IF NOT EXISTS `Usuarios` (
    `username` varchar(50) COLLATE utf8mb4_general_ci NOT NULL, 
    `password` varchar(70) COLLATE utf8mb4_general_ci NOT NULL,
    `nombre` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
    `correo` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
    `rol` varchar(15) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Usuario',
    `ventas` INT (20),
    PRIMARY KEY (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `Vinilos` (
    `id` INT (11) NOT NULL AUTO_INCREMENT,
    `titulo` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
    `autor` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
    `idAutor` INT (11) NOT NULL,
    `precio` INT(15) NOT NULL,
    `portada` varchar(50) NOT NULL,
    `ventas` INT(11) NOT NULL DEFAULT 0,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `Artistas` (
    `id` INT (11) NOT NULL AUTO_INCREMENT,
    `nombre` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
    `vinilo` INT(11) NOT NULL,
    `seguidores` INT (50) NOT NULL,
    `eventos` DATETIME,
    `foto` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`vinilo`) REFERENCES `Vinilos`(`id`),
    FOREIGN KEY (`nombre`) REFERENCES `Vinilos`(`idAutor`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `Comentarios` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `vinilo_id` INT(11) NOT NULL,
    `autor` varchar(50) NOT NULL,
    `comentario` varchar(100) NOT NULL,
    `fecha` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `padre` INT(11),
    PRIMARY KEY (`id`),
    FOREIGN KEY (`autor`) REFERENCES `Usuarios`(`username`),
    FOREIGN KEY (`vinilo_id`) REFERENCES `Vinilos`(`id`),
    FOREIGN KEY (`padre`) REFERENCES `Comentarios`(`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `Compras`(
   `User` varchar(50) NOT NULL,
   `IdVinilo` INT(11) NOT NULL,
   `compra` BOOLEAN NOT NULL DEFAULT false,
   PRIMARY KEY (`User`, `IdVinilo`),
   FOREIGN KEY (`User`) REFERENCES `Usuarios`(`username`),
   FOREIGN KEY (`IdVinilo`) REFERENCES `Vinilos`(`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `Canciones`(
    `id` INT (11) NOT NULL AUTO_INCREMENT,
    `idVinilo` INT (11) NOT NULL,
    `titulo` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
    `audio` varchar(50) NOT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`idVinilo`) REFERENCES `Vinilos`(`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `Discografia`(
    `id` INT (11) NOT NULL AUTO_INCREMENT,
    `idArtista` INT (11) NOT NULL,
    `idVinilo` INT (11) NOT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`idArtista`) REFERENCES `Artistas`(`id`),
    FOREIGN KEY (`idVinilo`) REFERENCES `Vinilos`(`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `Seguidos`(
    `id` INT (11) NOT NULL AUTO_INCREMENT,
    `idArtista` INT (11) NOT NULL,
    `idUser` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`idArtista`) REFERENCES `Artistas`(`id`),
    FOREIGN KEY (`idUser`) REFERENCES `Usuarios`(`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `Eventos`(
    `id` INT (11) NOT NULL AUTO_INCREMENT,
    `fecha` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `titulo` varchar(50) COLLATE utf8mb4_general_ci,
    `autor` varchar(50) COLLATE utf8mb4_general_ci,
    `precio` INT(15),
    `canciones` varchar(50),
    `portada` varchar(50),
    PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

