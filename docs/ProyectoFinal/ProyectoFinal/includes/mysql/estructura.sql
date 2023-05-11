
/*
  Recuerda que deshabilitar la opción "Enable foreign key checks" para evitar problemas a la hora de importar el script.
*/
DROP TABLE IF EXISTS `Usuarios`;
DROP TABLE IF EXISTS `Vinilos`;
DROP TABLE IF EXISTS `Artistas`;
DROP TABLE IF EXISTS `Comentarios`;
DROP TABLE IF EXISTS `Compras`;
DROP TABLE IF EXISTS `Canciones`;
DROP TABLE IF EXISTS `Seguidos`;
DROP TABLE IF EXISTS `Eventos`;
DROP TABLE IF EXISTS `Valoraciones`;

CREATE TABLE IF NOT EXISTS `Usuarios` (
    `username` varchar(50) COLLATE utf8mb4_general_ci NOT NULL, 
    `password` varchar(70) COLLATE utf8mb4_general_ci NOT NULL,
    `nombre` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
    `correo` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
    `rol` varchar(15) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Usuario',
    PRIMARY KEY (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `Artistas` (
    `id` INT (11) NOT NULL AUTO_INCREMENT,
    `nombre` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
    `seguidores` INT (50) NOT NULL,
    `eventos` DATETIME,
    `foto` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
    PRIMARY KEY (`id`)
--     /* FOREIGN KEY (`vinilo`) REFERENCES `Vinilos`(`id`)
--    FOREIGN KEY (`nombre`) REFERENCES `Vinilos`(`autor`) */
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `Vinilos` (
    `id` INT (11) NOT NULL AUTO_INCREMENT,
    `titulo` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
    `autor` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
    `idAutor` INT (11) NOT NULL,
    `precio` DECIMAL(10,2) NOT NULL,
    `portada` varchar(50) NOT NULL,
    `ventas` INT(11) NOT NULL,
    `stock` INT(11) NOT NULL,
    `valoracion` DECIMAL(10,2) NOT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`idAutor`) REFERENCES `Artistas`(`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `Comentarios` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `idVinilo` INT(11) NOT NULL,
    `autor` varchar(50) NOT NULL,
    `comentario` varchar(200) NOT NULL,
    `fecha` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `padre` INT(11),
    PRIMARY KEY (`id`),
    FOREIGN KEY (`autor`) REFERENCES `Usuarios`(`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `Valoraciones`(
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `idVinilo` INT(11) NOT NULL,
    `idUser` varchar(50) NOT NULL,
    `valoracion` INT(11) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `Compras`(
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `user` varchar(50) NOT NULL,
    `idVinilo` INT (11) NOT NULL,
    `precio` DECIMAL(10,2),
    `enCesta` BOOLEAN NOT NULL DEFAULT false,
    `comprado` BOOLEAN NOT NULL DEFAULT false,
    `fechaCompra` DATE NOT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`User`) REFERENCES `Usuarios`(`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `Canciones`(
    `id` INT (11) NOT NULL AUTO_INCREMENT,
    `idVinilo` INT (11) NOT NULL,
    `titulo` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
    `audio` varchar(50) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `Seguidos`(
    `id` INT (11) NOT NULL AUTO_INCREMENT,
    `idArtista` INT (11) NOT NULL,
    `idUser` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (`idArtista`) REFERENCES `Artistas`(`id`),
    FOREIGN KEY (`idUser`) REFERENCES `Usuarios`(`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `Eventos`(
    `id` INT (11) NOT NULL AUTO_INCREMENT,
    `fecha` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `idArtista` INT (11) NOT NULL,
    `tipo` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
    `descripcion` varchar(150) COLLATE utf8mb4_general_ci,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
