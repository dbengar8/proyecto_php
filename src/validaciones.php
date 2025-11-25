<?php
/**
 * src/validaciones.php
 * Funciones para limpiar y validar datos.
 */

/**
 * Limpia espacios y caracteres especiales para evitar XSS
 */
function limpiarEntrada($dato) {
    $dato = trim($dato);
    $dato = stripslashes($dato);
    $dato = htmlspecialchars($dato);
    return $dato;
}

/**
 * Valida formato de DNI español (8 números + Letra correcta)
 */
function validarDni($dni) {
    $dni = strtoupper(trim($dni));
    if (preg_match('/^[0-9]{8}[A-Z]$/', $dni)) {
        $numero = substr($dni, 0, 8);
        $letra = substr($dni, -1);
        $letrasValidas = "TRWAGMYFPDXBNJZSQVHLCKE";
        $indice = $numero % 23;
        
        if ($letrasValidas[$indice] == $letra) {
            return true;
        }
    }
    return false;
}

/**
 * Valida formato de email
 */
function validarEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

/**
 * Valida teléfono (9 dígitos, empezando por 6, 7, 8 o 9)
 */
function validarTelefono($telefono) {
    return preg_match('/^[6789][0-9]{8}$/', $telefono);
}

/**
 * Valida que una fecha sea correcta y no futura (opcional lo de futura)
 */
function validarFecha($fecha) {
    // Formato esperado YYYY-MM-DD (input type date)
    $partes = explode('-', $fecha);
    if (count($partes) == 3) {
        return checkdate($partes[1], $partes[2], $partes[0]);
    }
    return false;
}

/**
 * Verifica si una opción existe en un array de datos permitidos
 */
function validarOpcion($valor, $arrayOpciones) {
    return array_key_exists($valor, $arrayOpciones);
}