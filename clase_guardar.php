<?php
require_once 'config.php';

function esDiaHabil($fecha) {
    $dia = date('N', strtotime($fecha)); // 1=Lunes, 7=Domingo
    return ($dia >= 1 && $dia <= 5);
}

function horaValida($hora) {
    $horas_permitidas = ['10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00'];
    return in_array($hora, $horas_permitidas);
}

function clienteSinClaseEseDia($pdo, $cliente_id, $fecha) {
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM clases WHERE cliente_id = ? AND fecha = ? AND borrado = FALSE");
    $stmt->execute([$cliente_id, $fecha]);
    return $stmt->fetchColumn() == 0;
}

function profesorDisponible($pdo, $fecha, $hora, $vehiculo_id = null) {
    // Primero, intentar encontrar un profesor que ya haya usado este vehículo antes
    if ($vehiculo_id) {
        $stmt = $pdo->prepare("
            SELECT p.*, 
                   (SELECT COUNT(*) FROM clases 
                    WHERE profesor_id = p.id AND fecha = ? AND borrado = FALSE) as clases_hoy
            FROM profesores p
            WHERE p.borrado = FALSE 
            AND p.id NOT IN (
                SELECT profesor_id FROM clases 
                WHERE fecha = ? AND hora = ? AND borrado = FALSE
            )
            AND p.id IN (
                SELECT DISTINCT profesor_id FROM clases 
                WHERE vehiculo_id = ? AND borrado = FALSE
            )
            AND (SELECT COUNT(*) FROM clases 
                 WHERE profesor_id = p.id AND fecha = ? AND borrado = FALSE) < 4
            ORDER BY clases_hoy ASC
            LIMIT 1
        ");
        $stmt->execute([$fecha, $fecha, $hora, $vehiculo_id, $fecha]);
        $profesor = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($profesor) {
            return $profesor;
        }
    }
    
    // Si no hay profesor que haya usado ese vehículo, buscar cualquier profesor disponible
    $stmt = $pdo->prepare("
        SELECT p.*, 
               (SELECT COUNT(*) FROM clases 
                WHERE profesor_id = p.id AND fecha = ? AND borrado = FALSE) as clases_hoy
        FROM profesores p
        WHERE p.borrado = FALSE 
        AND p.id NOT IN (
            SELECT profesor_id FROM clases 
            WHERE fecha = ? AND hora = ? AND borrado = FALSE
        )
        AND (SELECT COUNT(*) FROM clases 
             WHERE profesor_id = p.id AND fecha = ? AND borrado = FALSE) < 4
        ORDER BY clases_hoy ASC
        LIMIT 1
    ");
    $stmt->execute([$fecha, $fecha, $hora, $fecha]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function vehiculoDisponible($pdo, $fecha, $hora, $profesor_id = null) {
    // Primero, intentar encontrar un vehículo que ya haya usado este profesor antes
    if ($profesor_id) {
        $stmt = $pdo->prepare("
            SELECT v.*
            FROM vehiculos v
            WHERE v.borrado = FALSE 
            AND v.id NOT IN (
                SELECT vehiculo_id FROM clases 
                WHERE fecha = ? AND hora = ? AND borrado = FALSE
            )
            AND v.id IN (
                SELECT DISTINCT vehiculo_id FROM clases 
                WHERE profesor_id = ? AND borrado = FALSE
            )
            LIMIT 1
        ");
        $stmt->execute([$fecha, $hora, $profesor_id]);
        $vehiculo = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($vehiculo) {
            return $vehiculo;
        }
    }
    
    // Si no hay vehículo que haya usado ese profesor, buscar cualquier vehículo disponible
    $stmt = $pdo->prepare("
        SELECT v.*
        FROM vehiculos v
        WHERE v.borrado = FALSE 
        AND v.id NOT IN (
            SELECT vehiculo_id FROM clases 
            WHERE fecha = ? AND hora = ? AND borrado = FALSE
        )
        LIMIT 1
    ");
    $stmt->execute([$fecha, $hora]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Procesar el formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cliente_id = $_POST['cliente_id'];
    $fecha = $_POST['fecha'];
    $hora = $_POST['hora'];
    
    // VALIDACIONES
    $errores = [];
    
    // Validar día hábil
    if (!esDiaHabil($fecha)) {
        $errores[] = "Las clases solo se pueden programar de lunes a viernes.";
    }
    
    // Validar hora
    if (!horaValida($hora)) {
        $errores[] = "Hora no válida. Las clases son de 10:00 a 17:00.";
    }
    
    // Validar que el cliente no tenga clase ese día
    if (!clienteSinClaseEseDia($pdo, $cliente_id, $fecha)) {
        $errores[] = "Este cliente ya tiene una clase programada para este día.";
    }
    
    if (empty($errores)) {
        // Buscar profesor disponible
        $profesor = profesorDisponible($pdo, $fecha, $hora);
        
        if (!$profesor) {
            $errores[] = "No hay profesores disponibles para esta fecha y hora.";
        } else {
            // Buscar vehículo disponible (intentando usar el mismo que ha usado el profesor)
            $vehiculo = vehiculoDisponible($pdo, $fecha, $hora, $profesor['id']);
            
            if (!$vehiculo) {
                $errores[] = "No hay vehículos disponibles para esta fecha y hora.";
            } else {
                // ¡Todo OK! Insertar la clase
                try {
                    $stmt = $pdo->prepare("
                        INSERT INTO clases (cliente_id, profesor_id, vehiculo_id, fecha, hora) 
                        VALUES (?, ?, ?, ?, ?)
                    ");
                    $stmt->execute([$cliente_id, $profesor['id'], $vehiculo['id'], $fecha, $hora]);
                    
                    header('Location: agenda.php?mensaje=Clase programada correctamente');
                    exit;
                    
                } catch (PDOException $e) {
                    $errores[] = "Error al guardar la clase: " . $e->getMessage();
                }
            }
        }
    }
    
    // Si hay errores, mostrarlos y volver al formulario
    if (!empty($errores)) {
        session_start();
        $_SESSION['errores'] = $errores;
        $_SESSION['datos_form'] = $_POST;
        header('Location: clase_nueva.php');
        exit;
    }
} else {
    header('Location: clase_nueva.php');
    exit;
}
?>