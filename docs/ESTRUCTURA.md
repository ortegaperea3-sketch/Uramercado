# Organización del proyecto

```text
Uramercados_VSCode/
├── css/style.css           # Diseño visual compartido
├── config/
│   ├── auth.php            # Sesión, roles y autenticación
│   └── config.php          # Conexión y configuración de la app
├── db/urmercados.sql       # Creación de la base de datos
├── docs/
│   ├── capturas/           # Imágenes de evidencia
│   ├── demo/               # Demostración visual estática
│   ├── pruebas/            # Plan y matriz de pruebas
│   └── *.md                # Instalación, evidencias y guía
├── partials/
│   ├── header.php          # Barra de navegación compartida
│   └── footer.php          # Pie de página y carga de JavaScript
├── js/app.js               # Comportamientos del navegador
├── index.php               # Inicio de sesión
├── dashboard.php           # Resumen del inventario
├── inventario.php          # Consulta de existencias
├── movimiento.php          # Entradas y salidas
├── productos.php           # Gestión de productos
├── categorias.php          # Gestión de categorías
├── historial.php           # Historial de movimientos
├── reporte.php             # Reportes
└── logout.php              # Cierre de sesión
```

Las páginas quedan en la raíz, como las páginas del proyecto de referencia, para conservar las direcciones directas de XAMPP. `css/` y `js/` separan presentación y comportamiento. Se mantienen `config/`, `db/`, `partials/` y `docs/` porque la aplicación PHP también necesita organizar configuración, base de datos, componentes reutilizables y documentación.
