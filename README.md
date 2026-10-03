# Uramercados – Fase II

MVP web para gestión de inventario, desarrollado con PHP, MySQL, HTML, CSS y JavaScript, preparado para trabajar en Visual Studio Code + XAMPP.

## 1. Requisitos
- XAMPP con Apache, MySQL y PHP.
- Visual Studio Code.
- Navegador web moderno.

## 2. Instalación
1. Copia la carpeta `Uramercados_VSCode` dentro de `C:\xampp\htdocs\`.
2. Abre XAMPP y activa **Apache** y **MySQL**.
3. Entra a `http://localhost/phpmyadmin`.
4. Importa `db/urmercados.sql`.
5. Verifica en `config/config.php` que host, usuario, contraseña y base de datos coincidan con tu instalación (por defecto: `localhost`, usuario `root`, contraseña vacía, BD `urmercados`).
6. Si Apache usa otro puerto, entra con la URL correspondiente, por ejemplo `http://localhost:8080/Uramercados_VSCode/`.
7. Abre `http://localhost/Uramercados_VSCode/`.

## 3. Credenciales de demostración
- Administrador: `admin` / `password`
- Colaborador: `colaborador` / `password`

## 4. Funcionalidades
- Inicio de sesión y sesiones.
- Roles propietario/colaborador.
- Dashboard con indicadores.
- Consulta y filtrado de inventario.
- Entradas y salidas con transacción y validación de stock.
- Alertas de bajo stock.
- CRUD de productos para propietario.
- Gestión de categorías.
- Historial de movimientos con filtros.
- Reporte de inventario y movimientos.
- Recomendación básica de reposición como apoyo a decisiones.
- Validaciones del lado del servidor y cliente.
- Consultas preparadas PDO.

## 5. Estructura
`css/` contiene los estilos y `js/` los comportamientos del navegador, siguiendo la organización por carpetas del proyecto de referencia. `config/` contiene conexión y autenticación; `db/`, el esquema SQL; `partials/`, el encabezado y pie compartidos; y `docs/`, instalación, evidencias y pruebas. Las páginas PHP permanecen en la raíz para conservar rutas simples en XAMPP, como `localhost/Uramercados_VSCode/dashboard.php`.

## 6. Prueba rápida
1. Inicia sesión como `admin`.
2. Revisa el dashboard y las alertas.
3. Registra una entrada.
4. Registra una salida menor o igual al stock.
5. Intenta una salida superior al stock: el sistema debe rechazarla.
6. Crea o edita un producto.
7. Consulta el historial y el reporte.
8. Cierra sesión y prueba el acceso de colaborador.

## 7. Seguridad y calidad
Las contraseñas se almacenan con `password_hash`; las consultas usan PDO con parámetros; las salidas HTML se escapan; las salidas de inventario se validan dentro de una transacción para impedir stock negativo.

## 8. Relación con Fase I
La implementación conserva el alcance definido para Uramercados: inventario, productos/categorías, movimientos, alertas, reportes y apoyo a decisiones de compra/reposición. No se incluyen facturación electrónica, contabilidad, nómina, comercio electrónico ni integraciones externas.
