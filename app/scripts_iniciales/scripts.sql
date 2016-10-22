/* Crear la tabla de usuarios
=================================================================*/
CREATE TABLE IF NOT EXISTS usuarios (
  id int(11) unsigned NOT NULL AUTO_INCREMENT,
  nombre varchar(100) NOT NULL DEFAULT '',
  pass text NOT NULL,
  mail varchar(100) DEFAULT '',
  tel varchar(15) DEFAULT '',
  tipo int(1) DEFAULT '1',
  status int(1) DEFAULT '1',
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/* Crear la tabla de unidades de medida
=================================================================*/
CREATE TABLE IF NOT EXISTS unidades_medida (
  id int(11) unsigned NOT NULL AUTO_INCREMENT,
  nombre varchar(20) NOT NULL DEFAULT '',
  conversion double NOT NULL DEFAULT '1',
  base int(11) DEFAULT NULL,
  status int(1) DEFAULT '1',
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/* Agrega unidades iniciales a la tabla
================================================================*/
INSERT IGNORE INTO
	unidades_medida
	(nombre, conversion, base)
VALUES
	('Pieza', 1, ''),
	('Miligramo', 1, ''),
	('Gramo', 1000, 2),
	('Kilo', 1000000, 2),
	('Mililitro', 1, ''),
	('litro', 1000000, 5);
	
/* Crea la tabla de productos
================================================================*/
CREATE TABLE IF NOT EXISTS productos (
  id int(11) unsigned NOT NULL AUTO_INCREMENT,
  nombre varchar(30) NOT NULL DEFAULT '',
  codigo varchar(30) NOT NULL DEFAULT '',
  precio decimal(10,2) NOT NULL,
  imagen text,
  unidad_compra int(11) DEFAULT NULL,
  unidad_venta int(11) DEFAULT NULL,
  status int(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;