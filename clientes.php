<?php
require_once 'config.php';

// Procesar búsqueda
$search = isset($_GET['search']) ? $_GET['search'] : '';
$sql = "SELECT * FROM clientes WHERE borrado = FALSE";
$params = [];

if (!empty($search)) {
    $sql .= " AND (nombre LIKE :search OR apellidos LIKE :search OR dni LIKE :search OR email LIKE :search)";
    $params[':search'] = "%$search%";
}

$sql .= " ORDER BY apellidos, nombre";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Clientes</title>
    <style>
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .btn { padding: 5px 10px; text-decoration: none; color: white; border-radius: 3px; }
        .btn-edit { background-color: #4CAF50; }
        .btn-delete { background-color: #f44336; }
        .btn-add { background-color: #008CBA; }
        .search-box { margin-bottom: 20px; }
    </style>
</head>
<body>
    <h1>Gestión de Clientes</h1>
    
    <div class="search-box">
        <form method="GET">
            <input type="text" name="search" placeholder="Buscar por nombre, DNI o email" value="<?php echo htmlspecialchars($search); ?>">
            <button type="submit">Buscar</button>
            <a href="clientes.php" style="margin-left: 10px;">Limpiar</a>
        </form>
    </div>
    
    <a href="cliente_form.php" class="btn btn-add">➕ Nuevo Cliente</a>
    <br><br>
    
    <table>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Apellidos</th>
            <th>DNI</th>
            <th>Teléfono</th>
            <th>Email</th>
            <th>Acciones</th>
        </tr>
        <?php foreach ($clientes as $cliente): ?>
        <tr>
            <td><?php echo $cliente['id']; ?></td>
            <td><?php echo htmlspecialchars($cliente['nombre']); ?></td>
            <td><?php echo htmlspecialchars($cliente['apellidos']); ?></td>
            <td><?php echo htmlspecialchars($cliente['dni']); ?></td>
            <td><?php echo htmlspecialchars($cliente['telefono']); ?></td>
            <td><?php echo htmlspecialchars($cliente['email']); ?></td>
            <td>
                <a href="cliente_form.php?id=<?php echo $cliente['id']; ?>" class="btn btn-edit">Editar</a>
                <a href="cliente_borrar.php?id=<?php echo $cliente['id']; ?>" class="btn btn-delete" onclick="return confirm('¿Estás seguro?')">Borrar</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <br>
    <a href="index.php">Volver al inicio</a>
</body>
</html>