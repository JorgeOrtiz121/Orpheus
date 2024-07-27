<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "orpheus2";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Manejar eliminación de productos
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_id'])) {
    $delete_id = intval($_POST['delete_id']); // Convertir a entero para seguridad
    $delete_sql = "DELETE FROM productos WHERE id = ?";
    $stmt = $conn->prepare($delete_sql);
    $stmt->bind_param("i", $delete_id);

    if ($stmt->execute()) {
        header('Location: index.php'); // Redirigir después de eliminar
        exit();
    } else {
        echo "Error al eliminar el producto: " . $conn->error;
    }
}

// Manejar búsqueda
$busqueda = ''; //la variable va a estar inicializada en vacio eso es porque cuando le enviemos resultados vacios debe dar todo la data o sino una data especifica
if (isset($_GET['busqueda'])) { // isset nos hace entender que debe estar seteado con algo, no debe estar vacio o null
    $busqueda = $_GET['busqueda'];
    $busqueda = $conn->real_escape_string($busqueda); // Escapar caracteres especiales para evitar inyecciones SQL
    $sql = "SELECT productos.id, productos.codigo, productos.nombre AS producto_nombre, productos.stock, marcas.nombre AS marca_nombre 
            FROM productos 
            JOIN marcas ON productos.marca_id = marcas.id 
            WHERE productos.nombre LIKE ? OR productos.codigo LIKE ?"; // los ? nos ayuda a ocultar variable para que no sea un query en texto
    $searchTerm = '%' . $busqueda . '%';
    $stmt = $conn->prepare($sql);// preparamos el prepared statement
    $stmt->bind_param("ss", $searchTerm, $searchTerm);// Los parametros nos ayuda a decir que esas dos ? son de tipo string
} else {
    $sql = "SELECT productos.id, productos.codigo, productos.nombre AS producto_nombre, productos.stock, marcas.nombre AS marca_nombre 
            FROM productos 
            JOIN marcas ON productos.marca_id = marcas.id";
    $stmt = $conn->prepare($sql);
}

$stmt->execute(); //realizamos la execucion
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Productos</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Lista de Productos</h1>
        <form action="" method="get">
            <div class="form-group">
                <input type="text" name="busqueda" class="form-control" placeholder="Digite para buscar" value="<?php echo htmlspecialchars($busqueda); ?>">
            </div>
            <button type="submit" class="btn btn-primary">Buscar</button>
        </form>
        <br>
        <table class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Código</th>
                    <th>Nombre</th>
                    <th>Stock</th>
                    <th>Marca</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) { // la diferencia entre fetch_object y assoc es porque a uno lo vemos como objeto y otor como array asociativo
                        echo "<tr>
                                <td>{$row['id']}</td>
                                <td>{$row['codigo']}</td>
                                <td>{$row['producto_nombre']}</td>
                                <td>{$row['stock']}</td>
                                <td>{$row['marca_nombre']}</td>
                                <td>
                                    <form method='post' action=''>
                                        <input type='hidden' name='delete_id' value='{$row['id']}'>
                                        <button type='submit' class='btn btn-danger btn-sm'>Eliminar</button>
                                    </form>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='6' class='text-center'>No hay productos</td></tr>";
                }
                ?>
            </tbody>
        </table>
        <a href="crearproducto.php" class="btn btn-primary">Agregar Nuevo Producto</a>
    </div>
</body>
</html>

<?php
$conn->close(); //cerramos la secion de conexion de mysql
?>
