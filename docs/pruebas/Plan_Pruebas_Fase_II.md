# Plan formal de pruebas — Fase II Uramercados

## Objetivo
Verificar el comportamiento funcional del MVP, sus reglas de inventario, seguridad básica, navegación y generación de información, manteniendo trazabilidad con los módulos definidos en la Fase I.

## Criterios
- **Aprobado:** resultado observado coincide con el esperado.
- **Fallido:** existe una diferencia que afecta el comportamiento esperado.
- **Bloqueado:** no puede ejecutarse por una dependencia del entorno.
- **Pendiente:** aún no se ha ejecutado en el entorno del estudiante.

> Importante: esta matriz define los casos de prueba; los estados de ejecución deben actualizarse con evidencia real después de ejecutar el sistema en XAMPP.

| ID | Módulo | Caso | Precondición | Resultado esperado | Estado inicial |
|---|---|---|---|---|---|
| CP-01 | Acceso | Login con credenciales válidas | Usuario activo | Ingresa al dashboard | Pendiente |
| CP-02 | Acceso | Login con contraseña incorrecta | Usuario existente | Muestra error y no inicia sesión | Pendiente |
| CP-03 | Acceso | Usuario inexistente | Sin sesión | Muestra error | Pendiente |
| CP-04 | Seguridad | Acceso directo sin sesión | Sin autenticación | Redirige al login | Pendiente |
| CP-05 | Sesión | Cerrar sesión | Sesión activa | Destruye sesión y vuelve al login | Pendiente |
| CP-06 | Dashboard | Cargar indicadores | Sesión válida | Muestra productos, stock y alertas | Pendiente |
| CP-07 | Inventario | Consultar listado | Sesión válida | Lista productos y existencias | Pendiente |
| CP-08 | Inventario | Buscar producto | Productos cargados | Filtra coincidencias | Pendiente |
| CP-09 | Inventario | Detectar bajo stock | Producto bajo mínimo | Muestra alerta | Pendiente |
| CP-10 | Movimientos | Registrar entrada válida | Producto activo | Incrementa stock y registra movimiento | Pendiente |
| CP-11 | Movimientos | Registrar salida válida | Stock suficiente | Reduce stock y registra movimiento | Pendiente |
| CP-12 | Movimientos | Salida mayor al stock | Stock insuficiente | Rechaza operación | Pendiente |
| CP-13 | Movimientos | Cantidad cero | Formulario abierto | Rechaza cantidad inválida | Pendiente |
| CP-14 | Movimientos | Cantidad negativa | Formulario abierto | Rechaza cantidad inválida | Pendiente |
| CP-15 | Movimientos | Producto inexistente | Datos manipulados | No registra operación | Pendiente |
| CP-16 | Historial | Filtrar por producto | Existen movimientos | Muestra movimientos del producto | Pendiente |
| CP-17 | Historial | Filtrar por tipo | Existen entradas/salidas | Muestra el tipo seleccionado | Pendiente |
| CP-18 | Historial | Filtrar por fecha | Existen movimientos | Muestra coincidencias | Pendiente |
| CP-19 | Reportes | Cargar reporte de inventario | Sesión válida | Presenta existencias y alertas | Pendiente |
| CP-20 | Reportes | Revisar recomendación | Datos de stock disponibles | Presenta apoyo de reposición | Pendiente |
| CP-21 | Productos | Crear producto | Rol propietario | Producto creado | Pendiente |
| CP-22 | Productos | Editar producto | Rol propietario | Cambios guardados | Pendiente |
| CP-23 | Categorías | Crear categoría | Rol propietario | Categoría creada | Pendiente |
| CP-24 | Roles | Colaborador intenta función restringida | Sesión colaborador | Acceso restringido | Pendiente |
| CP-25 | Seguridad | XSS en campo de texto | Formulario abierto | Salida escapada, sin ejecutar script | Pendiente |
| CP-26 | Persistencia | Recargar después de movimiento | Movimiento realizado | Stock conserva valor | Pendiente |
| CP-27 | Integridad | Registrar movimiento y stock | BD disponible | Operación transaccional consistente | Pendiente |
| CP-28 | UI | Navegación principal | Sesión válida | Enlaces cargan módulos correctos | Pendiente |

## Registro de ejecución
Completar las columnas `resultado observado`, `evidencia` y `estado final` durante la ejecución real.
