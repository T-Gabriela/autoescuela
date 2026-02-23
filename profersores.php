<?php
require_once 'config.php';

$search = isset($_GET['search']) ? $_GET['search'] : '';
$sql = "SELECT * FROM profesores WHERE borrado = FALSE";
$params = [];

if (!empty($search)) {
    $sql .= " AND (nombre LIKE :search OR apellidos LIKE :search OR dni LIKE :search)";
    $params[':search'] = "%$search%";
}

$sql .= " ORDER BY apellidos, nombre";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$profesores = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Profesores</title>
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
    <h1>Gestión de Profesores</h1>
    
    <div class="search-box">
        <form method="GET">
            <input type="text" name="search" placeholder="Buscar por nombre, apellidos o DNI" value="<?php echo htmlspecialchars($search); ?>">
            <button type="submit">Buscar</button>
            <a href="profesores.php" style="margin-left: 10px;">Limpiar</a>
        </form>
    </div>
    
    <a href="profesor_form.php" class="btn btn-add">➕ Nuevo Profesor</a>
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
        <?php foreach ($profesores as $profesor): ?>
        <tr>
            <td><?php echo $profesor['id']; ?></td>
            <td><?php echo htmlspecialchars($profesor['nombre']); ?></td>
            <td><?php echo htmlspecialchars($profesor['apellidos']); ?></td>
            <td><?php echo htmlspecialchars($profesor['dni']); ?></td>
            <td><?php echo htmlspecialchars($profesor['telefono']); ?></td>
            <td><?php echo htmlspecialchars($profesor['email']); ?></td>
            <td>
                <a href="profesor_form.php?id=<?php echo $profesor['id']; ?>" class="btn btn-edit">Editar</a>
                <a href="profesor_borrar.php?id=<?php echo $profesor['id']; ?>" class="btn btn-delete" onclick="return confirm('¿Estás seguro?')">Borrar</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <br>
    <a href="index.php">Volver al inicio</a>
</body>
</html>