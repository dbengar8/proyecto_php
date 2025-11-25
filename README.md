Gestión de Empleados - Proyecto PHP Modular

Este proyecto consiste en una aplicación web desarrollada en PHP nativo para gestionar el alta de empleados de una empresa. Se ha diseñado siguiendo una arquitectura modular, separando la lógica de negocio, los datos y la vista, cumpliendo con los requisitos de validación y sanitización de datos.

📋 Requisitos del Sistema

Para ejecutar este proyecto necesitas:

PHP 7.4 o superior.

Un servidor web (Apache, Nginx) o utilizar el servidor integrado de PHP.

Navegador web moderno.

🚀 Instalación y Ejecución

Clonar el repositorio (o descargar los archivos):

git clone https://github.com/dbengar8/proyecto_php
cd proyecto_php


Iniciar el servidor:
La forma más sencilla de probar la aplicación sin configurar Apache/XAMPP es utilizar el servidor interno de PHP. Ejecuta el siguiente comando desde la raíz del proyecto:

php -S localhost:8000 -t public


Acceder a la aplicación:
Abre tu navegador y visita: http://localhost:8000

Estructura del Proyecto

El código se ha organizado en dos directorios principales para mantener la separación de responsabilidades:

/
├── public/                 # Archivos accesibles por el navegador
│   ├── index.php           # Controlador frontal y vista principal
│   └── estilos.css         # Hoja de estilos CSS
│
├── src/                    # Lógica interna y datos (Backend)
│   ├── datos.php           # "Base de datos" simulada (arrays de opciones)
│   ├── validaciones.php    # Biblioteca de funciones de validación
│   └── vistas.php          # Helpers para renderizar HTML (selects, errores)
│
└── README.md               # Documentación del proyecto


🛠️ Detalles Técnicos y Funcionalidades

1. Validación de Datos (src/validaciones.php)

Se han implementado funciones específicas para asegurar la integridad de los datos:

DNI: Se verifica el formato (8 números + Letra) y se calcula la letra correcta mediante el algoritmo del módulo 23.

Email: Uso de filter_var con FILTER_VALIDATE_EMAIL.

Teléfono: Validación mediante Expresiones Regulares (Regex) para formato español (9 dígitos empezando por 6, 7, 8 o 9).

Fechas: Comprobación de existencia real de la fecha (checkdate).

2. Seguridad (limpiarEntrada)

Para prevenir ataques básicos como XSS (Cross-Site Scripting), todos los datos de entrada pasan por una función de sanitización que aplica:

trim(): Elimina espacios innecesarios.

stripslashes(): Elimina barras invertidas.

htmlspecialchars(): Convierte caracteres especiales en entidades HTML.

3. Persistencia de Datos

Si el formulario contiene errores, el sistema mantiene los datos introducidos por el usuario en los campos correctos, evitando que tenga que reescribir todo el formulario (función valorAntiguo).

4. Modularidad (src/datos.php)

Los datos de Provincias, Sedes y Departamentos no están "hardcodeados" en el HTML, sino que se cargan dinámicamente desde arrays PHP, simulando una carga desde base de datos y facilitando el mantenimiento futuro.