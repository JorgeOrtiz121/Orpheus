<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body class="container mt-5">
    <h2>Crud de Trabajadores</h2>
    <form class="col-4" method="POST" >
 
   <?php
   //Llama de las librerias o modulos creados y formulario creado para el trabajador
    include "conexion.php";
    include "creartrabajador.php";
    include "eliminartrab.php";
    

    ?>
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre Usuario:</label>
            <input type="text" name="nombre" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="apellido" class="form-label">Apellido Usuario:</label>
            <input type="text" name="apellido" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email:</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="telefono" class="form-label">Teléfono:</label>
            <input type="text" name="telefono" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary" name="btn-presionar" value="ok">Crear</button>
    </form>

    <table class="table mt-5">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nombre</th>
                <th scope="col">Apellido</th>
                <th scope="col">Email</th>
                <th scope="col">Teléfono</th>
                <th scope="col">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            //se realiza la conexion para mostrar la informacion que contiene el trabajador como lista
            include "conexion.php";
            $sql = $conn->query("SELECT * FROM trabajadores");
            $counter = 1;
            
            while ($datos = $sql->fetch_object()) { ?>
                <tr>
                    <th scope="row"><?= $counter++ ?></th>
                    <td><?= htmlspecialchars($datos->nombre) ?></td>
                    <td><?= htmlspecialchars($datos->apellido) ?></td>
                    <td><?= htmlspecialchars($datos->email) ?></td>
                    <td><?= htmlspecialchars($datos->telefono) ?></td>
                    <td>
                        <!---- todo href tiene como argumento el id de quien vamos a visualizar---->
                        <a href="modificar.php?id=<?= htmlspecialchars($datos->id) ?>" class="btn btn-warning btn-sm">Editar</a>
                        <a href="eliminartrab.php?id=<?= htmlspecialchars($datos->id) ?>" class="btn btn-danger btn-sm">Eliminar</a>
                        <a href="crearinformaciontrabajador.php?id=<?= htmlspecialchars($datos->id) ?>" class="btn btn-danger btn-sm">Su informacion</a>

                    </td>
                </tr>

            <?php } ?>

          
        </tbody>
       
    </table>
</body>

</html>
