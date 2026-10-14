-- Ejecuta esta migración UNA SOLA VEZ si ya tienes la base urmercados creada.
-- No la ejecutes después de importar el esquema actualizado db/urmercados.sql.
USE urmercados;
ALTER TABLE cuenta_proveedor ADD COLUMN forma_pago ENUM('contado','credito') NOT NULL DEFAULT 'credito' AFTER valor;
ALTER TABLE cuenta_cliente ADD COLUMN forma_pago ENUM('contado','credito') NOT NULL DEFAULT 'credito' AFTER valor;
ALTER TABLE cuenta_proveedor ADD COLUMN fecha_factura DATE NULL AFTER forma_pago;
UPDATE cuenta_proveedor SET fecha_factura=fecha_pago WHERE fecha_factura IS NULL;
ALTER TABLE cuenta_proveedor MODIFY fecha_factura DATE NOT NULL;
ALTER TABLE cuenta_cliente ADD COLUMN fecha_factura DATE NULL AFTER forma_pago;
UPDATE cuenta_cliente SET fecha_factura=fecha_cobro WHERE fecha_factura IS NULL;
ALTER TABLE cuenta_cliente MODIFY fecha_factura DATE NOT NULL;
