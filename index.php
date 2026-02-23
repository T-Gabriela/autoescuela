<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Autoescuela - Gestión</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        h1 { color: #333; }
        .menu { display: flex; gap: 20px; flex-wrap: wrap; }
        .menu-item { 
            background: #f0f0f0; 
            padding: 20px; 
            border-radius: 5px;
            text-align: center;
            min-width: 150px;
        }
        .menu-item a { 
            text-decoration: none; 
            color: #333;
            font-weight: bold;
        }
        .menu-item:hover { background: #e0e0e0; }
    </style>
</head>
<body>
    <h1>Sistema de Gestión de Autoescuela</h1>
    
    <div class="menu">
        <div class="menu-item">
            <a href="clientes.php">👤 Gestionar Clientes</a>
        </div>
        <div class="menu-item">
            <a href="profesores.php">👨‍🏫 Gestionar Profesores</a>
        </div>
        <div class="menu-item">
            <a href="vehiculos.php">🚗 Gestionar Vehículos</a>
        </div>
        <div class="menu-item">
            <a href="agenda.php">📅 Gestión de Clases</a>
        </div>
    </div>
</body>
</html>