<?php
//del name que contiene el boton btn-mod se enviara la solicitud con los inputs registrados y se modificara mediante la conexion a mysql
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["btn-mod"])) {
    if (!empty($_POST["nombre"]) && !empty($_POST["apellido"]) && !empty($_POST["email"]) && !empty($_POST["telefono"])) {
        $id = $_GET["id"];
        $nombre = $_POST["nombre"];
        $apellido = $_POST["apellido"];
        $email = $_POST["email"];
        $telefono = $_POST["telefono"];
        // se realiza prepared statement para evitar inyeccion sql y se conecta con el query de update
        $sql = $conn->prepare("UPDATE trabajadores SET nombre = ?, apellido = ?, email = ?, telefono = ? WHERE id = ?");
        $sql->bind_param("ssssi", $nombre, $apellido, $email, $telefono, $id);
        if ($sql->execute()) {
            echo "Trabajador modificado exitosamente.";
            header("location:paginaphp.php");
        } else {
            echo "Error al modificar: " . $sql->error;
        }
    
        $sql->close();

    }
}
?>