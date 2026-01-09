<?php
/**
 * src/validaciones.php
 * Contiene SOLAMENTE funciones para validar y limpiar datos.
 */

function limpiarEntrada($dato) {
    $dato = trim($dato);
    $dato = stripslashes($dato);
    $dato = htmlspecialchars($dato);
    return $dato;
}

function validarDni($dni) {
    $dni = strtoupper(trim($dni));
    if (preg_match('/^[0-9]{8}[A-Z]$/', $dni)) {
        $numero = substr($dni, 0, 8);
        $letra = substr($dni, -1);
        $letrasValidas = "TRWAGMYFPDXBNJZSQVHLCKE";
        $indice = $numero % 23;
        return ($letrasValidas[$indice] == $letra);
    }
    return false;
}

function validarEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function validarTelefono($telefono) {
    return preg_match('/^[6789][0-9]{8}$/', $telefono);
}

function validarFecha($fecha) {
    $partes = explode('-', $fecha);
    if (count($partes) == 3) {
        return checkdate($partes[1], $partes[2], $partes[0]);
    }
    return false;
}

function validarOpcion($valor, $arrayOpciones) {
    return array_key_exists($valor, $arrayOpciones);
}
