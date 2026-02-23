<?php
require_once 'config.php';


$clientes = $pdo->query("SELECT id, nombre, apellidos, dni FROM clientes WHERE borrado = FALSE ORDER BY apellidos")->fetchAll();


$fecha_default = date('Y-m-d');
$hora_default = '10:00';


$dia_semana = date('N', strtotime($fecha_default)); // 1=Lunes, 7=Domingo
if ($dia_semana > 5) {
    
    $fecha_default = date('Y-m-d', strtotime('next monday'));
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Nueva Clase</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input, select { width: 300px; padding: 8px; border: 1px solid #ddd; border-radius: 3px; }
        .btn { padding: 10px 20px; background-color: #4CAF50; color: white; border: none; cursor: pointer; border-radius: 3px; text-decoration: none; display: inline-block; }
        .btn-cancel { background-color: #f44336; }
        .info { background-color: #e3f2fd; padding: 10px; border-radius: 3px; margin-bottom: 20px; }
        .info ul { margin: 5px 0; padding-left: 20px; }
    </style>
</head>
<body>
    <h1>➕ Programar Nueva Clase</h1>
    
    <div class="info">
        <strong>📌 Normas de la autoescuela:</strong>
        <ul>
            <li>Clases de 1 hora, de 10:00 a 17:00</li>
            <li>Solo lunes a viernes</li>
            <li>Máximo 1 clase por cliente al día</li>
            <li>Máximo 4 horas por profesor al día</li>
        </ul>
    </div>
    
    <form action="clase_guardar.php" method="POST">
        <div class="form-group">
            <label for="cliente_id">Cliente:</label>
            <select id="cliente_id" name="cliente_id" required>
                <option value="">Seleccione un cliente</option>
                <?php foreach ($clientes as $cliente): ?>
                    <option value="<?php echo $cliente['id']; ?>">
                        <?php echo htmlspecialchars($cliente['apellidos'] . ', ' . $cliente['nombre'] . ' (' . $cliente['dni'] . ')'); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <div class="form-group">
            <label for="fecha">Fecha:</label>
            <input type="date" id="fecha" name="fecha" value="<?php echo $fecha_default; ?>" required min="<?php echo date('Y-m-d'); ?>">
        </div>
        
        <div class="form-group">
            <label for="hora">Hora:</label>
            <select id="hora" name="hora" required>
                <option value="10:00">10:00 - 11:00</option>
                <option value="11:00">11:00 - 12:00</option>
                <option value="12:00">12:00 - 13:00</option>
                <option value="13:00">13:00 - 14:00</option>
                <option value="14:00">14:00 - 15:00</option>
                <option value="15:00">15:00 - 16:00</option>
                <option value="16:00">16:00 - 17:00</option>
                <option value="17:00">17:00 - 18:00</option>
            </select>
        </div>
        
        <button type="submit" class="btn">Guardar Clase</button>
        <a href="agenda.php" class="btn btn-cancel">Cancelar</a>
    </form>
    
    <br>
    <a href="index.php">← Volver al inicio</a>
</body>
</html>