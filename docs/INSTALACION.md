# Instalación local — Uramercados

## Requisitos
- XAMPP con Apache, MySQL y PHP.
- Visual Studio Code.
- Navegador web moderno.

## Pasos
1. Copiar la carpeta del proyecto a `C:\xampp\htdocs\`.
2. Iniciar Apache y MySQL desde XAMPP.
3. Abrir phpMyAdmin.
4. Importar `db/urmercados.sql`.
5. Revisar `config/config.php` si la instalación de MySQL usa una contraseña distinta para `root`.
6. Abrir `http://localhost/Uramercados_VSCode/`.

## Acceso al sistema
Solicita tus credenciales directamente al administrador del sistema. No se publican en la pantalla de inicio de sesión.

## Recorrido sugerido para la demostración
1. Iniciar sesión.
2. Mostrar dashboard y alertas.
3. Consultar inventario.
4. Registrar entrada.
5. Registrar salida válida.
6. Intentar salida superior al stock.
7. Consultar historial.
8. Revisar reporte y recomendación de reposición.
9. Mostrar productos/categorías con usuario propietario.
10. Cerrar sesión.

## Facturas y cuentas por cobrar/pagar

Si es una instalación nueva, el esquema actualizado ya crea las columnas necesarias. Para una base existente que todavía no recibió la migración de facturas, importa una vez `db/actualizar_facturas.sql`. Si ya habías ejecutado esa migración anteriormente, importa solamente `db/actualizar_fecha_factura.sql` para añadir la fecha de compra/venta. No vuelvas a importar el esquema completo sobre una base en uso. Después inicia sesión como propietario, agrega clientes/proveedores en **Clientes y proveedores** y registra las facturas en **Facturas y cuentas**. La alarma se muestra al abrir esta pantalla e incluye vencimientos de hoy, próximos tres días y cuentas atrasadas.
