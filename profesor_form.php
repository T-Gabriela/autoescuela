<?php
require_once 'config.php';

$profesor = [
    'id' => '',
    'nombre' => '',
    'apellidos' => '',
    'dni' => '',
    'telefono' => '',
    'email' => ''
];

if (isset($_GET['id'])) {
    $stmt = $pdo->prepare("SELECT * FROM profesores WHERE id = ? AND borrado = FALSE");
    $stmt->execute([$_GET['id']]);
    $profesor = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$profesor) {
        header('Location: profesores.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo $profesor['id'] ? 'Editar' : 'Nuevo'; ?> Profesor</title>
    <style>
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input[type="text"], input[type="email"] { width: 300px; padding: 5px; }
        .btn { padding: 10px 20px; background-color: #4CAF50; color: white; border: none; cursor: pointer; }
        .btn-cancel { background-color: #f44336; }
    </style>
</head>
<body>
    <h1><?php echo $profesor['id'] ? 'Editar Profesor' : 'Nuevo Profesor'; ?></h1>
    
    <form action="profesor_guardar.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $profesor['id']; ?>">
        
        <div class="form-group">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($profesor['nombre']); ?>" required>
        </div>
        
        <div class="form-group">
            <label for="apellidos">Apellidos:</label>
            <input type="text" id="apellidos" name="apellidos" value="<?php echo htmlspecialchars($profesor['apellidos']); ?>" required>
        </div>
        
        <div class="form-group">
            <label for="dni">DNI:</label>
            <input type="text" id="dni" name="dni" value="<?php echo htmlspecialchars($profesor['dni']); ?>" required>
        </div>
        
        <div class="form-group">
            <label for="telefono">Teléfono:</label>
            <input type="text" id="telefono" name="telefono" value="<?php echo htmlspecialchars($profesor['telefono']); ?>">
        </div>
        
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($profesor['email']); ?>">
        </div>
        
        <button type="submit" class="btn">Guardar</button>
        <a href="profesores.php" class="btn btn-cancel">Cancelar</a>
    </form>
</body>
</html>