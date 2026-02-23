<?php
require_once 'config.php';


$fecha = isset($_GET['fecha']) ? $_GET['fecha'] : date('Y-m-d');
$cliente_id = isset($_GET['cliente_id']) ? $_GET['cliente_id'] : '';
$profesor_id = isset($_GET['profesor_id']) ? $_GET['profesor_id'] : '';


$sql = "SELECT c.*, 
               cl.nombre as cliente_nombre, cl.apellidos as cliente_apellidos,
               p.nombre as profesor_nombre, p.apellidos as profesor_apellidos,
               v.matricula, v.marca, v.modelo
        FROM clases c
        INNER JOIN clientes cl ON c.cliente_id = cl.id
        INNER JOIN profesores p ON c.profesor_id = p.id
        INNER JOIN vehiculos v ON c.vehiculo_id = v.id
        WHERE c.borrado = FALSE AND cl.borrado = FALSE AND p.borrado = FALSE AND v.borrado = FALSE";

$params = [];

if (!empty($fecha)) {
    $sql .= " AND c.fecha = :fecha";
    $params[':fecha'] = $fecha;
}

if (!empty($cliente_id)) {
    $sql .= " AND c.cliente_id = :cliente_id";
    $params[':cliente_id'] = $cliente_id;
}

if (!empty($profesor_id)) {
    $sql .= " AND c.profesor_id = :profesor_id";
    $params[':profesor_id'] = $profesor_id;
}

$sql .= " ORDER BY c.fecha, c.hora";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$clases = $stmt->fetchAll(PDO::FETCH_ASSOC);


$clientes = $pdo->query("SELECT id, nombre, apellidos FROM clientes WHERE borrado = FALSE ORDER BY apellidos")->fetchAll();
$profesores = $pdo->query("SELECT id, nombre, apellidos FROM profesores WHERE borrado = FALSE ORDER BY apellidos")->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Agenda de Clases</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        table { border-collapse: collapse; width: 100%; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #4CAF50; color: white; }
        tr:nth-child(even) { background-color: #f2f2f2; }
        .filtros { background-color: #f9f9f9; padding: 15px; border-radius: 5px; margin-bottom: 20px; }
        .filtros form { display: flex; gap: 10px; flex-wrap: wrap; align-items: flex-end; }
        .filtros .grupo { display: flex; flex-direction: column; }
        .filtros label { font-weight: bold; margin-bottom: 5px; }
        .filtros input, .filtros select { padding: 5px; width: 150px; }
        .btn { padding: 8px 15px; background-color: #4CAF50; color: white; border: none; cursor: pointer; border-radius: 3px; text-decoration: none; display: inline-block; }
        .btn-eliminar { background-color: #f44336; }
        .btn:hover { opacity: 0.8; }
        .horas { display: grid; grid-template-columns: repeat(8, 1fr); gap: 5px; margin-top: 20px; }
        .hora { border: 1px solid #ddd; padding: 10px; text-align: center; cursor: pointer; }
        .hora.ocupada { background-color: #ffcdd2; cursor: not-allowed; }
        .hora.disponible { background-color: #c8e6c9; }
        .hora:hover:not(.ocupada) { background-color: #a5d6a7; }
    </style>
</head>
<body>
    <h1>📅 Agenda de Clases</h1>
    
    <div class="filtros">
        <form method="GET">
            <div class="grupo">
                <label>Fecha:</label>
                <input type="date" name="fecha" value="<?php echo $fecha; ?>">
            </div>
            
            <div class="grupo">
                <label>Cliente:</label>
                <select name="cliente_id">
                    <option value="">Todos los clientes</option>
                    <?php foreach ($clientes as $cliente): ?>
                        <option value="<?php echo $cliente['id']; ?>" <?php echo $cliente_id == $cliente['id'] ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($cliente['apellidos'] . ', ' . $cliente['nombre']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="grupo">
                <label>Profesor:</label>
                <select name="profesor_id">
                    <option value="">Todos los profesores</option>
                    <?php foreach ($profesores as $profesor): ?>
                        <option value="<?php echo $profesor['id']; ?>" <?php echo $profesor_id == $profesor['id'] ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($profesor['apellidos'] . ', ' . $profesor['nombre']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="grupo">
                <label>&nbsp;</label>
                <button type="submit" class="btn">Filtrar</button>
                <a href="agenda.php" class="btn" style="background-color: #ff9800;">Limpiar</a>
            </div>
        </form>
    </div>
    
    <a href="clase_nueva.php" class="btn" style="margin-bottom: 20px;">➕ Nueva Clase</a>
    
    <?php if (empty($clases)): ?>
        <p>No hay clases programadas para los filtros seleccionados.</p>
    <?php else: ?>
        <table>
            <tr>
                <th>Fecha</th>
                <th>Hora</th>
                <th>Cliente</th>
                <th>Profesor</th>
                <th>Vehículo</th>
                <th>Acciones</th>
            </tr>
            <?php foreach ($clases as $clase): ?>
            <tr>
                <td><?php echo date('d/m/Y', strtotime($clase['fecha'])); ?></td>
                <td><?php echo $clase['hora']; ?></td>
                <td><?php echo htmlspecialchars($clase['cliente_nombre'] . ' ' . $clase['cliente_apellidos']); ?></td>
                <td><?php echo htmlspecialchars($clase['profesor_nombre'] . ' ' . $clase['profesor_apellidos']); ?></td>
                <td><?php echo htmlspecialchars($clase['matricula'] . ' - ' . $clase['marca'] . ' ' . $clase['modelo']); ?></td>
                <td>
                    <a href="clase_borrar.php?id=<?php echo $clase['id']; ?>" class="btn btn-eliminar" onclick="return confirm('¿Eliminar esta clase?')">🗑️ Eliminar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
    
    <br>
    <a href="index.php">← Volver al inicio</a>
</body>
</html>