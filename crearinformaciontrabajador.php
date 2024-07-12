<?php
include "conexion.php";
// el banderin editando esta en falso debido que al momento de cargar la pagina esta el fomruario vacio entonces
// al momento de editar se cambia de banderin y su estado se cambia a modificar
// por eso id_trabajador y salario y puesto estan vacios
$editando = false;
$id_trabajador = '';
$salario = '';
$puesto = '';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql_editar = $conn->prepare("SELECT * FROM informacion WHERE id = ?");
    $sql_editar->bind_param("i", $id);
    $sql_editar->execute();
    $resultado = $sql_editar->get_result();
    $fila_editar = $resultado->fetch_object();

    if ($fila_editar) {
        $editando = true;
        $id_trabajador = $fila_editar->id_trabajador;
        $salario = $fila_editar->salario;
        $puesto = $fila_editar->puesto_trabajo;
    }
}
//al momento de capturar lo que se envia del formulario con el boton informacion captura la data y mediante los prepared statement
// se visualiza se se creara o modificara
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["btn-informacion"])) {
    $id_trabajador = $_POST["idtrab"];
    $salario = $_POST["salario"];
    $puesto = $_POST["puesto"];

    if ($editando) {
        $id = $_POST["id"];
        $sql = $conn->prepare("UPDATE informacion SET salario = ?, puesto_trabajo = ? WHERE id = ?");
        $sql->bind_param("dsi", $salario, $puesto, $id);
        // todo header con location estamos redireccionando
        header("location:paginaphp.php");
    } else {
        $sql = $conn->prepare("INSERT INTO informacion (id_trabajador, salario, puesto_trabajo) VALUES (?, ?, ?)");
        $sql->bind_param("iss", $id_trabajador, $salario, $puesto);
    }

    if ($sql->execute()) {
        echo '<div class="alert alert-success" role="alert">Operación realizada correctamente.</div>';
    } else {
        echo '<div class="alert alert-danger" role="alert">Error al procesar la operación: ' . $conn->error . '</div>';
    }

    $sql->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Información del Trabajador</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <h2>Información del Trabajador</h2>
    
    <?php if ($editando): //en el formulario ponemos requerimiento para que se llene los inputs?>
        <form class="col-4" method="POST" action="">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
            <div class="mb-3">
                <label for="idtrab" class="form-label">ID Trabajador</label>
                <input type="text" name="idtrab" class="form-control" value="<?php echo htmlspecialchars($id_trabajador); ?>" required readonly>
            </div>
            <div class="mb-3">
                <label for="salario" class="form-label">Salario</label>
                <input type="text" name="salario" class="form-control" value="<?php echo htmlspecialchars($salario); ?>" required>
            </div>
            <div class="mb-3">
                <label for="puesto" class="form-label">Puesto</label>
                <input type="text" name="puesto" class="form-control" value="<?php echo htmlspecialchars($puesto); ?>" required>
            </div>
            <button type="submit" class="btn btn-primary" name="btn-informacion">Modificar</button>
        </form>
    <?php else: ?>
        <form class="col-4" method="POST" action="">
            <div class="mb-3">
                <label for="idtrab" class="form-label">ID Trabajador</label>
                <input type="text" name="idtrab" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="salario" class="form-label">Salario</label>
                <input type="text" name="salario" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="puesto" class="form-label">Puesto</label>
                <input type="text" name="puesto" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary" name="btn-informacion">Crear</button>
        </form>
    <?php endif; ?>

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
            $id=$_GET['id'];
            $sql = "SELECT * FROM informacion where id_trabajador=$id";
            $resultados = $conn->query($sql);
            $counter = 1;
            while ($datos = $resultados->fetch_object()) { ?>
                <tr>
                    <th scope="row"><?= $counter++ ?></th>
                    <td><?= htmlspecialchars($datos->id_trabajador) ?></td>
                    <td><?= htmlspecialchars($datos->salario) ?></td>
                    <td><?= htmlspecialchars($datos->puesto_trabajo) ?></td>
                    <td>
            <!---- tener en cuenta que href tiene el ?id= porque mandamos como argumento el id para solo ver de un usuario seleccionado ---->
                        <a href="?id=<?= htmlspecialchars($datos->id) ?>" class="btn btn-warning btn-sm">Editar</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</body>
</html>
