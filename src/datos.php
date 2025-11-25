<?php
/**
 * src/datos.php
 * Simula una base de datos con arrays estáticos.
 */

function obtenerProvincias() {
    return [
        'madrid' => 'Madrid',
        'barcelona' => 'Barcelona',
        'valencia' => 'Valencia',
        'sevilla' => 'Sevilla',
        'malaga' => 'Málaga',
        'bilbao' => 'Bilbao'
    ];
}

function obtenerSedes() {
    return [
        'central' => 'Sede Central',
        'norte' => 'Delegación Norte',
        'sur' => 'Delegación Sur',
        'este' => 'Delegación Este'
    ];
}

function obtenerDepartamentos() {
    return [
        'it' => 'Tecnología (IT)',
        'rrhh' => 'Recursos Humanos',
        'marketing' => 'Marketing y Ventas',
        'finanzas' => 'Contabilidad y Finanzas',
        'logistica' => 'Logística'
    ];
}