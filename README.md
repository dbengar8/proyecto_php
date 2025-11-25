# Gestión de Empleados - Proyecto PHP Modular

Este proyecto consiste en una aplicación web desarrollada en PHP nativo para gestionar el alta de empleados de una empresa. Se ha diseñado siguiendo una **arquitectura modular**, separando la lógica de negocio, los datos y la vista, cumpliendo con los requisitos de validación y sanitización de datos.

## Requisitos del Sistema

Para ejecutar este proyecto necesitas:
* **PHP 7.4** o superior.
* Un servidor web (Apache, Nginx) o utilizar el servidor integrado de PHP.
* Navegador web moderno.

## Instalación y Ejecución

1. **Clonar el repositorio** (o descargar los archivos):
   ```bash
   git clone https://github.com/dbengar8/proyecto_php
   cd proyecto_php
   ```
## Estructura del proyecto:
```bash
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
```