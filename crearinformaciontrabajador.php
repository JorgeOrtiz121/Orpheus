<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body class="container mt-5">
    <h2>Crud de informaciones</h2>

    <?php
    // Procesamiento del formulario de creación o modificación con la idea que cuando se cree el trabajador exista un espacio
    // para registrar su informacion
    include "conexion.php";

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["btn-informacion"])) {
        // Obtener datos del formulario
        $idtrab = $_POST["idtrab"];
        $salario = $_POST["salario"];
        $puesto = $_POST["puesto"];

        // Determinar si se está creando un nuevo registro o actualizando uno existente
        if (isset($_POST["id"])) {
            // Modificación de información existente
            $id = $_POST["id"];
            $sql = $conn->prepare("UPDATE informacion SET id_trabajador = ?, salario = ?, puesto_trabajo = ? WHERE id = ?");
            $sql->bind_param("issi", $idtrab, $salario, $puesto, $id);
        } else {
            // Creación de nuevo registro
            $sql = $conn->prepare("INSERT INTO informacion (id_trabajador, salario, puesto_trabajo) VALUES (?, ?, ?)");
            $sql->bind_param("iss", $idtrab, $salario, $puesto);
        }

        if ($sql->execute()) {
            echo '<div class="alert alert-success" role="alert">Operación realizada correctamente.</div>';
        } else {
            echo '<div class="alert alert-danger" role="alert">Error al procesar la operación: ' . $conn->error . '</div>';
        }

        $sql->close();
    }

    // Obtener datos para editar (si se proporciona un ID)
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $sql_editar = $conn->prepare("SELECT * FROM informacion WHERE id = ?");
        $sql_editar->bind_param("i", $id);
        $sql_editar->execute();
        $resultado = $sql_editar->get_result();
        $fila_editar = $resultado->fetch_object();
    }
    ?>

    <!-- Formulario donde se visualiza que la iformacion a quien va relacionado-->
    <form class="col-4" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <input type="hidden" name="id" value="<?php echo isset($fila_editar) ? $fila_editar->id : ''; ?>">
        <div class="mb-3">
            <label for="idtrab" class="form-label">ID Trabajador:</label>
            <input type="text" name="idtrab" class="form-control" value="<?php echo isset($fila_editar) ? $fila_editar->id_trabajador : ''; ?>" required>
        </div>
        <div class="mb-3">
            <label for="salario" class="form-label">Salario:</label>
            <input type="text" name="salario" class="form-control" value="<?php echo isset($fila_editar) ? $fila_editar->salario : ''; ?>" required>
        </div>
        <div class="mb-3">
            <label for="puesto" class="form-label">Puesto:</label>
            <input type="text" name="puesto" class="form-control" value="<?php echo isset($fila_editar) ? $fila_editar->puesto_trabajo : ''; ?>" required>
        </div>
        <button type="submit" class="btn btn-primary" name="btn-informacion" value="ok"><?php echo isset($fila_editar) ? 'Modificar' : 'Crear'; ?></button>
    </form>

    <!-- Tabla de Información -->
    <table class="table mt-5">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">ID Trabajador</th>
                <th scope="col">Salario</th>
                <th scope="col">Puesto</th>
                <th scope="col">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Mostrar registros actuales
            $sql_select = $conn->query("SELECT * FROM informacion");
            $counter = 1;
            while ($datos = $sql_select->fetch_object()) { ?>
                <tr>
                    <th scope="row"><?= $counter++ ?></th>
                    <td><?= htmlspecialchars($datos->id_trabajador) ?></td>
                    <td><?= htmlspecialchars($datos->salario) ?></td>
                    <td><?= htmlspecialchars($datos->puesto_trabajo) ?></td>
                    <td>
                        <a href="?id=<?= htmlspecialchars($datos->id) ?>" class="btn btn-warning btn-sm">Editar</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</body>
</html>
