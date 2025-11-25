<?php
/**
 * src/vistas.php
 * Funciones auxiliares para pintar elementos HTML.
 */

/**
 * Genera un <select> con opciones, manteniendo la selección previa.
 * * @param string $nombre name e id del input
 * @param array $opciones Array clave => valor
 * @param string $seleccionado Valor seleccionado actualmente
 */
function pintarSelect($nombre, $opciones, $seleccionado) {
    $html = "<select name='$nombre' id='$nombre' class='form-control'>";
    $html .= "<option value=''>-- Seleccione --</option>";
    
    foreach ($opciones as $clave => $valor) {
        $selectedAttr = ($clave == $seleccionado) ? 'selected' : '';
        $html .= "<option value='$clave' $selectedAttr>$valor</option>";
    }
    
    $html .= "</select>";
    return $html;
}

/**
 * Muestra el mensaje de error si existe para un campo dado
 */
function mostrarError($errores, $campo) {
    if (isset($errores[$campo])) {
        return "<span class='mensaje-error'>{$errores[$campo]}</span>";
    }
    return "";
}

/**
 * Recupera el valor antiguo del formulario para no obligar a reescribir
 */
function valorAntiguo($campo, $datos) {
    return isset($datos[$campo]) ? $datos[$campo] : '';
}