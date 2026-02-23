<?php
require_once 'config.php';

$vehiculo = [
    'id' => '',
    'matricula' => '',
    'marca' => '',
    'modelo' => '',
    'anyo' => ''
];

if (isset($_GET['id'])) {
    $stmt = $pdo->prepare("SELECT * FROM vehiculos WHERE id = ? AND borrado = FALSE");
    $stmt->execute([$_GET['id']]);
    $vehiculo = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$vehiculo) {
        header('Location: vehiculos.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo $vehiculo['id'] ? 'Editar' : 'Nuevo'; ?> Vehículo</title>
    <style>
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input[type="text"], input[type="number"] { width: 300px; padding: 5px; }
        .btn { padding: 10px 20px; background-color: #4CAF50; color: white; border: none; cursor: pointer; }
        .btn-cancel { background-color: #f44336; }
    </style>
</head>
<body>
    <h1><?php echo $vehiculo['id'] ? 'Editar Vehículo' : 'Nuevo Vehículo'; ?></h1>
    
    <form action="vehiculo_guardar.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $vehiculo['id']; ?>">
        
        <div class="form-group">
            <label for="matricula">Matrícula:</label>
            <input type="text" id="matricula" name="matricula" value="<?php echo htmlspecialchars($vehiculo['matricula']); ?>" required>
        </div>
        
        <div class="form-group">
            <label for="marca">Marca:</label>
            <input type="text" id="marca" name="marca" value="<?php echo htmlspecialchars($vehiculo['marca']); ?>" required>
        </div>
        
        <div class="form-group">
            <label for="modelo">Modelo:</label>
            <input type="text" id="modelo" name="modelo" value="<?php echo htmlspecialchars($vehiculo['modelo']); ?>" required>
        </div>
        
        <div class="form-group">
            <label for="any