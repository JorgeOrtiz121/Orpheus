<?php
include "conexion.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = $conn->prepare("DELETE FROM trabajadores WHERE id = ?");
    $sql->bind_param("i", $id);

    if ($sql->execute()) {
        echo "Registro eliminado exitosamente.";
        header("location:paginaphp.php");
    } else {
        echo "Error al eliminar el registro: " . $sql->error;
    }

    $sql->close();
} else {
    echo "Ya eliminado.";
}
?>
