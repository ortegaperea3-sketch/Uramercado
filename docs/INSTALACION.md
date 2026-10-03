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

## Usuarios de demostración
- Propietario: `admin` / `password`
- Colaborador: `colaborador` / `password`

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
