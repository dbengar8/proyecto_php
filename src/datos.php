<?php
/**
 * src/datos.php
 * Contiene SOLAMENTE las funciones que interactúan con la base de datos.
 */

require_once 'db.php';

function obtenerProvincias() {
    try {
        $pdo = conectarBD();
        $stmt = $pdo->query("SELECT id, nombre FROM provincias");
        return $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
    } catch (Exception $e) {
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

function guardarEmpleado($datos) {
    $pdo = conectarBD();
    $sql = "INSERT INTO empleados (nombre, apellidos, dni, email, telefono, fecha_alta, sede_id, departamento_id) 
            VALUES (:nombre, :apellidos, :dni, :email, :telefono, :fecha, :sede, :depto)";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':nombre' => $datos['nombre'],
        ':apellidos' => $datos['apellidos'],
        ':dni' => $datos['dni'],
        ':email' => $datos['email'],
        ':telefono' => $datos['telefono'],
        ':fecha' => $datos['fecha_alta'],
        ':sede' => $datos['sede'],
        ':depto' => $datos['departamento']
    ]);
}
