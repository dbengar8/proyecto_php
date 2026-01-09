<?php
require_once 'db.php';

/**
 * Obtiene las provincias desde la BD y las devuelve en formato array [id => nombre]
 */
function obtenerProvincias() {
    try {
        $pdo = conectarBD();
        $stmt = $pdo->query("SELECT id, nombre FROM provincias");
        return $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
    } catch (Exception $e) {
        // Si falla, devolvemos array vacío para que no rompa la web, o podríamos loguear el error
        return [];
    }
}

function obtenerSedes() {
    try {
        $pdo = conectarBD();
        $stmt = $pdo->query("SELECT id, nombre FROM sedes");
        return $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
    } catch (Exception $e) {
        return [];
    }
}

function obtenerDepartamentos() {
    try {
        $pdo = conectarBD();
        $stmt = $pdo->query("SELECT id, nombre FROM departamentos");
        return $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
    } catch (Exception $e) {
        return [];
    }
}

/**
 * Guarda el empleado en la base de datos
 */
function guardarEmpleado($datos) {
    $pdo = conectarBD();
    $sql = "INSERT INTO empleados (nombre, apellidos, dni, email, telefono, fecha_alta, sede_id, departamento_id) 
            VALUES (:nombre, :apellidos, :dni, :email, :telefono, :fecha, :sede, :depto)";
    
    $stmt = $pdo->prepare($sql);
    
    // Asignamos los valores a los parámetros
    $stmt->execute([
        ':nombre' => $datos['nombre'],
        ':apellidos' => $datos['apellidos'],
        ':dni' => $datos['dni'],
        ':email' => $datos['email'],
        ':telefono' => $datos['telefono'],
        ':fecha' => $datos['fecha_alta'],
        ':sede' => $datos['sede'], // Aquí llega el ID seleccionado del select
        ':depto' => $datos['departamento'] // Aquí llega el ID seleccionado del select
    ]);
}
