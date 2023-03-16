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
    `precio` INT(15) NOT NULL,
    `canciones` varchar(50) NOT NULL,
    `portada` varchar(50) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `Artistas` (
    `id` INT (11) NOT NULL AUTO_INCREMENT,
    `nombre` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
    `vinilo` INT(11) NOT NULL,
    `seguidores` INT (50) NOT NULL,
    `eventos` DATETIME,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`vinilo`) REFERENCES `Vinilos`(`id`)
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
   `Id-Vinilo` INT(11) NOT NULL,
   PRIMARY KEY (`User`, `Id-Vinilo`),
   FOREIGN KEY (`User`) REFERENCES `Usuarios`(`username`),
   FOREIGN KEY (`Id-Vinilo`) REFERENCES `Vinilos`(`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

