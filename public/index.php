<?php
// Incluimos los archivos de lógica (subimos un nivel desde public con ../)
require_once '../src/datos.php';
require_once '../src/validaciones.php';
require_once '../src/vistas.php';

// Inicialización de variables
$errores = [];
$datos = [];
$mostrarResumen = false;

// Cargar listas de datos
$provincias = obtenerProvincias();
$sedes = obtenerSedes();
$departamentos = obtenerDepartamentos();

// Procesar el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // 1. Recoger y sanitizar datos
    $datos['nombre'] = limpiarEntrada($_POST['nombre'] ?? '');
    $datos['apellidos'] = limpiarEntrada($_POST['apellidos'] ?? '');
    $datos['dni'] = limpiarEntrada($_POST['dni'] ?? '');
    $datos['email'] = limpiarEntrada($_POST['email'] ?? '');
    $datos['telefono'] = limpiarEntrada($_POST['telefono'] ?? '');
    $datos['fecha_alta'] = limpiarEntrada($_POST['fecha_alta'] ?? '');
    $datos['provincia'] = limpiarEntrada($_POST['provincia'] ?? '');
    $datos['sede'] = limpiarEntrada($_POST['sede'] ?? '');
    $datos['departamento'] = limpiarEntrada($_POST['departamento'] ?? '');

    // 2. Validaciones
    if (empty($datos['nombre'])) $errores['nombre'] = "El nombre es obligatorio.";
    if (empty($datos['apellidos'])) $errores['apellidos'] = "Los apellidos son obligatorios.";
    
    if (empty($datos['dni']) || !validarDni($datos['dni'])) {
        $errores['dni'] = "El DNI no es válido o está vacío.";
    }

    if (empty($datos['email']) || !validarEmail($datos['email'])) {
        $errores['email'] = "El correo electrónico no es válido.";
    }

    if (!empty($datos['telefono']) && !validarTelefono($datos['telefono'])) {
        $errores['telefono'] = "El teléfono debe tener 9 dígitos.";
    }

    if (empty($datos['fecha_alta']) || !validarFecha($datos['fecha_alta'])) {
        $errores['fecha_alta'] = "La fecha no es válida.";
    }

    if (empty($datos['provincia']) || !validarOpcion($datos['provincia'], $provincias)) {
        $errores['provincia'] = "Seleccione una provincia válida.";
    }

    if (empty($datos['sede']) || !validarOpcion($datos['sede'], $sedes)) {
        $errores['sede'] = "Seleccione una sede válida.";
    }

    if (empty($datos['departamento']) || !validarOpcion($datos['departamento'], $departamentos)) {
        $errores['departamento'] = "Seleccione un departamento válido.";
    }

    // 3. Decisión
    if (empty($errores)) {
        $mostrarResumen = true;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alta de Empleado - Empresa XYZ</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>

<div class="contenedor">
    <h1>Gestión de Empleados</h1>

    <?php if ($mostrarResumen): ?>
        <!-- VISTA DE ÉXITO / RESUMEN -->
        <div class="resumen">
            <h2>¡Alta realizada correctamente!</h2>
            <p>Se han registrado los siguientes datos:</p>
            <ul>
                <li><strong>Nombre completo:</strong> <?php echo $datos['nombre'] . ' ' . $datos['apellidos']; ?></li>
                <li><strong>DNI:</strong> <?php echo $datos['dni']; ?></li>
                <li><strong>Email:</strong> <?php echo $datos['email']; ?></li>
                <li><strong>Teléfono:</strong> <?php echo $datos['telefono']; ?></li>
                <li><strong>Fecha de Alta:</strong> <?php echo $datos['fecha_alta']; ?></li>
                <li><strong>Provincia:</strong> <?php echo $provincias[$datos['provincia']]; ?></li>
                <li><strong>Sede:</strong> <?php echo $sedes[$datos['sede']]; ?></li>
                <li><strong>Departamento:</strong> <?php echo $departamentos[$datos['departamento']]; ?></li>
            </ul>
            <a href="index.php" class="btn-volver">Registrar otro empleado</a>
        </div>

    <?php else: ?>
        <!-- VISTA DE FORMULARIO -->
        <form action="index.php" method="POST" novalidate>
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" name="nombre" id="nombre" class="form-control" 
                       value="<?php echo valorAntiguo('nombre', $datos); ?>" placeholder="Ej: Juan">
                <?php echo mostrarError($errores, 'nombre'); ?>
            </div>

            <div class="form-group">
                <label for="apellidos">Apellidos:</label>
                <input type="text" name="apellidos" id="apellidos" class="form-control" 
                       value="<?php echo valorAntiguo('apellidos', $datos); ?>" placeholder="Ej: Pérez López">
                <?php echo mostrarError($errores, 'apellidos'); ?>
            </div>

            <div class="form-group">
                <label for="dni">DNI:</label>
                <input type="text" name="dni" id="dni" class="form-control" 
                       value="<?php echo valorAntiguo('dni', $datos); ?>" placeholder="Ej: 12345678Z">
                <?php echo mostrarError($errores, 'dni'); ?>
            </div>

            <div class="form-group">
                <label for="email">Correo Electrónico:</label>
                <input type="email" name="email" id="email" class="form-control" 
                       value="<?php echo valorAntiguo('email', $datos); ?>" placeholder="juan@empresa.com">
                <?php echo mostrarError($errores, 'email'); ?>
            </div>

            <div class="form-group">
                <label for="telefono">Teléfono:</label>
                <input type="tel" name="telefono" id="telefono" class="form-control" 
                       value="<?php echo valorAntiguo('telefono', $datos); ?>" placeholder="Ej: 600123456">
                <?php echo mostrarError($errores, 'telefono'); ?>
            </div>

            <div class="form-group">
                <label for="fecha_alta">Fecha de Alta:</label>
                <input type="date" name="fecha_alta" id="fecha_alta" class="form-control" 
                       value="<?php echo valorAntiguo('fecha_alta', $datos); ?>">
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