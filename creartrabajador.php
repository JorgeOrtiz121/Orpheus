<?php
// esta solicitud captura despues de enviar el formulario de trabajador para crear
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["btn-presionar"])) {
    
    if (!empty($_POST["nombre"]) && !empty($_POST["apellido"]) && !empty($_POST["email"]) && !empty($_POST["telefono"])) {
        $nombre = $_POST["nombre"];
        $apellido = $_POST["apellido"];
        $email = $_POST["email"];
        $telefono = $_POST["telefono"];
         
        // Preparar la consulta SQL para insertar los datos con prepared statement
        $sql = $conn->prepare("INSERT INTO trabajadores (nombre, apellido, email, telefono) VALUES (?, ?, ?, ?)");

        // Verificar si la preparación de la consulta fue exitosa
        if ($sql) {
            // Enlazar los parámetros
            $sql->bind_param("ssss", $nombre, $apellido, $email, $telefono);

            // Ejecutar la consulta
            if ($sql->execute()) {
                echo "Trabajador creado exitosamente.";
            } else {
                echo "Error al ejecutar la consulta: " . $sql->error;
            }

            // Cerrar la declaración
            $sql->close();
        } else {
            echo "Error al preparar la consulta: " . $conn->error;
        }
    } else {
        echo "Por favor, complete todos los campos.";
    }
}
?>
