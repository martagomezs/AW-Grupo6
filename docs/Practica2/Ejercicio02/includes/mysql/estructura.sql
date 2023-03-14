/*
  Recuerda que deshabilitar la opción "Enable foreign key checks" para evitar problemas a la hora de importar el script.
*/
DROP TABLE IF EXISTS `Usuarios`;
DROP TABLE IF EXISTS `Artista`;
DROP TABLE IF EXISTS `Vinilos`;
DROP TABLE IF EXISTS `Comentarios`;
DROP TABLE IF EXISTS `Compras`

CREATE TABLE IF NOT EXISTS 'Usuarios' (
  'id' int(11) NOT NULL AUTO_INCREMENT,
  'Contraseña' varchar(70) COLLATE utf8mb4_general_ci NOT NULL,
  'Ntarjeta' varchar(100) COLLATE utf8mb4_general_ci NOT NULL, --Hay que mirar la longitud una vez esté encriptada
  'Nombre' varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  'Correo' varchar(120) COLLATE utf8mb4_general_ci NOT NULL,
  'Rol' varchar(15) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY ('id')
  ) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

  CREATE TABLE IF NOT EXISTS 'Artista' (
  'id' int(11) NOT NULL AUTO_INCREMENT,
  'Contraseña' varchar(70) COLLATE utf8mb4_general_ci NOT NULL,
  'Ntarjeta' varchar(100) COLLATE utf8mb4_general_ci NOT NULL, --Hay que mirar la longitud una vez esté encriptada
  'Nombre' varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  'Correo' varchar(120) COLLATE utf8mb4_general_ci NOT NULL,
  'Rol' varchar(15) COLLATE utf8mb4_general_ci NOT NULL,
  'Ventas' int(20) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY ('id')
  ) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS 'Vinilos' (
  'id' int(11) NOT NULL AUTO_INCREMENT,
  'titulo' varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  'autor' varchar(15) COLLATE utf8mb4_general_ci NOT NULL,
  'precio' INT(15) NOT NULL,
  'canciones' BLOB NOT NULL,
  'portada' BLOB NOT NULL,
  PRIMARY KEY ('id')
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE IF NOT EXISTS 'Comentarios' (
    'id' INT(30) NOT NULL AUTO_INCREMENT,
    'vinilo_id' INT NOT NULL,
    'autor' VARCHAR(50) NOT NULL,
    'comentario' TEXT NOT NULL,
    'fecha' TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY ('id'),
    FOREIGN KEY ('autor') REFERENCES 'Usuarios'('Nombre'),
    FOREIGN KEY ('vinilo_id') REFERENCES 'Vinilos'('id')
); ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS 'Compras'(
  'Id-User' INT(11) NOT NULL,
  'Id-Vinilo' INT(11) NOT NULL,
  PRIMARY KEY ('Id-User', 'Id-Vinilo'),
  FOREIGN KEY ('Id-User') REFERENCES 'Usuarios'('id'),
  FOREIGN KEY ('Id-Vinilo') REFERENCES 'Vinilos'('id')
)
