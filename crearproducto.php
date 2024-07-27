<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "orpheus2";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $codigo = $_POST['codigo'];
    $nombre_producto = $_POST['nombre_producto'];
    $stock = $_POST['stock'];
    $marca_id = $_POST['marca_id'];
        $sql = $conn->prepare( "INSERT INTO productos (codigo, nombre, stock, marca_id) VALUES (?,?,?,?)");
        $sql->bind_param("ssii",$codigo,$nombre_producto,$stock,$marca_id);

        if ($sql->execute()) {
            echo "Nuevo producto creado correctamente";
            header("location:index.php");
    
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
  
   
}

$sql_marcas = "SELECT id, nombre FROM marcas";
$result_marcas = $conn->query($sql_marcas);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Agregar Producto</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Agregar Nuevo Producto</h1>
        <form method="post" action="">
            <div class="form-group">
                <label for="codigo">Código:</label>
                <input type="text" class="form-control" id="codigo" name="codigo" required>
            </div>
            <div class="form-group">
                <label for="nombre_producto">Nombre del Producto:</label>
                <input type="text" class="form-control" id="nombre_producto" name="nombre_producto" required>
            </div>
            <div class="form-group">
                <label for="stock">Stock:</label>
                <input type="number" class="form-control" id="stock" name="stock" required>
            </div>
            <div class="form-group">
                <label for="marca_id">Marca:</label>
                <select class="form-control" id="marca_id" name="marca_id" required>
                    <?php
                    if ($result_marcas->num_rows > 0) {
                        while($row = $result_marcas->fetch_assoc()) {
                            echo "<option value='{$row['id']}'>{$row['nombre']}</option>";
                        }
                    } else {
                        echo "<option value=''>No hay marcas disponibles</option>";
                    }
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Agregar Producto</button>
        </form>
        <br>
        <a href="index.php" class="btn btn-secondary">Volver a la Lista de Productos</a>
    </div>
</body>
</html>

<?php
$conn->close();
?>
