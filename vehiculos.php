<?php
require_once 'config.php';

$search = isset($_GET['search']) ? $_GET['search'] : '';
$sql = "SELECT * FROM vehiculos WHERE borrado = FALSE";
$params = [];

if (!empty($search)) {
    $sql .= " AND (matricula LIKE :search OR marca LIKE :search OR modelo LIKE :search)";
    $params[':search'] = "%$search%";
}

$sql .= " ORDER BY marca, modelo";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$vehiculos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Vehículos</title>
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
    <h1>Gestión de Vehículos</h1>
    
    <div class="search-box">
        <form method="GET">
            <input type="text" name="search" placeholder="Buscar por matrícula, marca o modelo" value="<?php echo htmlspecialchars($search); ?>">
            <button type="submit">Buscar</button>
            <a href="vehiculos.php" style="margin-left: 10px;">Limpiar</a>
        </form>
    </div>
    
    <a href="vehiculo_form.php" class="btn btn-add">➕ Nuevo Vehículo</a>
    <br><br>
    
    <table>
        <tr>
            <th>ID</th>
            <th>Matrícula</th>
            <th>Marca</th>
            <th>Modelo</th>
            <th>Año</th>
            <th>Acciones</th>
        </tr>
        <?php foreach ($vehiculos as $vehiculo): ?>
        <tr>
            <td><?php echo $vehiculo['id']; ?></td>
            <td><?php echo htmlspecialchars($vehiculo['matricula']); ?></td>
            <td><?php echo htmlspecialchars($vehiculo['marca']); ?></td>
            <td><?php echo htmlspecialchars($vehiculo['modelo']); ?></td>
            <td><?php echo $vehiculo['anyo']; ?></td>
            <td>
                <a href="vehiculo_form.php?id=<?php echo $vehiculo['id']; ?>" class="btn btn-edit">Editar</a>
                <a href="vehiculo_borrar.php?id=<?php echo $vehiculo['id']; ?>" class="btn btn-delete" onclick="return confirm('¿Estás seguro?')">Borrar</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <br>
    <a href="index.php">Volver al inicio</a>
</body>
</html>