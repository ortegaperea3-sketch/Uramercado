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

## 3. Acceso al sistema
Las credenciales deben ser compartidas directamente por el administrador con las personas autorizadas. No se muestran en la pantalla de acceso.

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
- Registro de facturas de compra y venta con número, tercero, concepto, forma contado/crédito y vencimiento.
- Cuentas pendientes por pagar a proveedores y por cobrar a clientes, con alarmas de vencimiento a tres días y registro de pagos/cobros.
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
La aplicación registra facturas y saldos básicos para seguimiento operativo. No genera facturación electrónica ni reemplaza un sistema contable.
# Instalación y actualización

Para una instalación nueva, importa `db/urmercados.sql` como indica este README. El esquema ya incluye la forma de pago de contado/crédito.

Si actualizas una instalación que ya tiene la base `urmercados`, conserva sus datos. Si todavía no habías ejecutado una migración de facturas, ejecuta una sola vez `db/actualizar_facturas.sql`. Si ya ejecutaste la migración de la versión anterior, ejecuta solo `db/actualizar_fecha_factura.sql` para añadir la fecha de compra/venta. No vuelvas a importar `db/urmercados.sql` sobre una base en uso, porque ese archivo reinicia las tablas.

En la aplicación, entra como propietario y usa **Clientes y proveedores** para registrar los terceros. En **Facturas y cuentas**, registra el número, concepto/mercancía, valor, forma de pago, fecha de compra/venta y vencimiento. Las facturas a crédito quedan pendientes; las de contado se guardan como saldadas. La alarma muestra cuentas vencidas y las que vencen dentro de los siguientes tres días. Usa el botón de la alarma para marcar un pago o cobro realizado.
