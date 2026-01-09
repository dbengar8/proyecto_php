<?php
/**
 * public/index.php
 * Punto de entrada: Procesa el formulario y muestra la vista.
 */

require_once '../src/db.php';          // Conexión
require_once '../src/datos.php';       // Funciones de BD
require_once '../src/validaciones.php';// Funciones de validación
require_once '../src/vistas.php';      // Helpers de HTML

$errores = [];
$datos = [];
$mostrarResumen = false;
$mensajeExito = "";
$mensajeErrorBD = "";

// Cargar listas desde BD
$provincias = obtenerProvincias();
$sedes = obtenerSedes();
$departamentos = obtenerDepartamentos();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // 1. Sanitizar
    $datos['nombre'] = limpiarEntrada($_POST['nombre'] ?? '');
    $datos['apellidos'] = limpiarEntrada($_POST['apellidos'] ?? '');
    $datos['dni'] = limpiarEntrada($_POST['dni'] ?? '');
    $datos['email'] = limpiarEntrada($_POST['email'] ?? '');
    $datos['telefono'] = limpiarEntrada($_POST['telefono'] ?? '');
    $datos['fecha_alta'] = limpiarEntrada($_POST['fecha_alta'] ?? '');
    $datos['provincia'] = limpiarEntrada($_POST['provincia'] ?? '');
    $datos['sede'] = limpiarEntrada($_POST['sede'] ?? '');
    $datos['departamento'] = limpiarEntrada($_POST['departamento'] ?? '');

    // 2. Validar
    if (empty($datos['nombre'])) $errores['nombre'] = "Nombre obligatorio.";
    if (empty($datos['apellidos'])) $errores['apellidos'] = "Apellidos obligatorios.";
    if (empty($datos['dni']) || !validarDni($datos['dni'])) $errores['dni'] = "DNI inválido.";
    if (empty($datos['email']) || !validarEmail($datos['email'])) $errores['email'] = "Email inválido.";
    if (!empty($datos['telefono']) && !validarTelefono($datos['telefono'])) $errores['telefono'] = "Teléfono inválido.";
    if (empty($datos['fecha_alta']) || !validarFecha($datos['fecha_alta'])) $errores['fecha_alta'] = "Fecha inválida.";
    
    // Validar selects
    if (empty($datos['provincia']) || !array_key_exists($datos['provincia'], $provincias)) $errores['provincia'] = "Provincia inválida.";
    if (empty($datos['sede']) || !array_key_exists($datos['sede'], $sedes)) $errores['sede'] = "Sede inválida.";
    if (empty($datos['departamento']) || !array_key_exists($datos['departamento'], $departamentos)) $errores['departamento'] = "Departamento inválido.";

    // 3. Guardar
    if (empty($errores)) {
        try {
            guardarEmpleado($datos);
            $mostrarResumen = true;
            $mensajeExito = "¡Empleado guardado en AWS RDS correctamente!";
        } catch (Exception $e) {
            $mensajeErrorBD = "Error en base de datos: " . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alta Empleados Cloud</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>

<div class="contenedor">
    <h1>Gestión de Empleados (Versión Cloud)</h1>

    <?php if ($mensajeErrorBD): ?>
        <div class="mensaje-error" style="background: #f8d7da; padding: 10px; margin-bottom: 10px; color: #721c24;">
            <?php echo $mensajeErrorBD; ?>
        </div>
    <?php endif; ?>

    <?php if ($mostrarResumen): ?>
        <div class="resumen">
            <h2><?php echo $mensajeExito; ?></h2>
            <ul>
                <li><strong>Nombre:</strong> <?php echo $datos['nombre'] . ' ' . $datos['apellidos']; ?></li>
                <li><strong>DNI:</strong> <?php echo $datos['dni']; ?></li>
                <li><strong>Sede:</strong> <?php echo $sedes[$datos['sede']] ?? 'Desconocida'; ?></li>
            </ul>
            <a href="index.php" class="btn-volver">Volver</a>
        </div>
    <?php else: ?>
        <form action="index.php" method="POST">
            <!-- (Aquí iría el resto de tu formulario HTML tal cual lo tenías) -->
             <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" name="nombre" id="nombre" class="form-control" value="<?php echo valorAntiguo('nombre', $datos); ?>">
                <?php echo mostrarError($errores, 'nombre'); ?>
            </div>
             <div class="form-group">
                <label for="apellidos">Apellidos:</label>
                <input type="text" name="apellidos" id="apellidos" class="form-control" value="<?php echo valorAntiguo('apellidos', $datos); ?>">
                <?php echo mostrarError($errores, 'apellidos'); ?>
            </div>
             <div class="form-group">
                <label for="dni">DNI:</label>
                <input type="text" name="dni" id="dni" class="form-control" value="<?php echo valorAntiguo('dni', $datos); ?>">
                <?php echo mostrarError($errores, 'dni'); ?>
            </div>
             <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" class="form-control" value="<?php echo valorAntiguo('email', $datos); ?>">
                <?php echo mostrarError($errores, 'email'); ?>
            </div>
             <div class="form-group">
                <label for="telefono">Teléfono:</label>
                <input type="text" name="telefono" id="telefono" class="form-control" value="<?php echo valorAntiguo('telefono', $datos); ?>">
                <?php echo mostrarError($errores, 'telefono'); ?>
            </div>
             <div class="form-group">
                <label for="fecha_alta">Fecha Alta:</label>
                <input type="date" name="fecha_alta" id="fecha_alta" class="form-control" value="<?php echo valorAntiguo('fecha_alta', $datos); ?>">
                <?php echo mostrarError($errores, 'fecha_alta'); ?>
            </div>

            <div class="form-group">
                <label for="provincia">Provincia:</label>
                <?php echo pintarSelect('provincia', $provincias, valorAntiguo('provincia', $datos)); ?>
                <?php echo mostrarError($errores, 'provincia'); ?>
            </div>

            <div class="form-group">
                <label for="sede">Sede:</label>
                <?php echo pintarSelect('sede', $sedes, valorAntiguo('sede', $datos)); ?>
                <?php echo mostrarError($errores, 'sede'); ?>
            </div>

            <div class="form-group">
                <label for="departamento">Departamento:</label>
                <?php echo pintarSelect('departamento', $departamentos, valorAntiguo('departamento', $datos)); ?>
                <?php echo mostrarError($errores, 'departamento'); ?>
            </div>

            <button type="submit">Dar de alta</button>
        </form>
    <?php endif; ?>
</div>

</body>
</html>
