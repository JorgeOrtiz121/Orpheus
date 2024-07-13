en este ejercicio lo realice con xampp en la carpeta de htdoc, el ejercicio muestra sobre el uso de querys y llamada de base de datos.
el ejercicio acorde a la descricion del reto es que al momento de crear el trabajador tambien crea su intancia de informacion que es de la otra tabla y se puede visualizar donde rincipalmente da la opcion 
de crear pero si seleccionamos en el boton editar de un item nos da la opcion de editar. Recalco que debemos ver que el id del trabajador ay que ponerlo en el input de id trabajador para poder acertar bien en 
la modificacion. les agradezco a orpheus por esta oportunidad y por aprender php , estoy feliz con eso y espero tener la oportunidad de trabajar con ustedes . gracias
querys 
CREATE TABLE `trabajadores` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telefono` varchar(100) NOT NULL
) 
si utilizamos cancade on delete si eliminamos un trabajador se elimina tambien la informacion

CREATE TABLE informacion (
 id int AUTO_INCREMENT PRIMARY KEY,
 id_trabajador int not null,
 foreign key (id_trabajador) REFERENCES trabajadores (id),
  salario varchar (25) not null,
  puesto_trabajo varchar (100) UNIQUE NOT null  
);
