-- Ejecuta esta migración UNA SOLA VEZ si ya habías aplicado actualizar_facturas.sql.
-- Agrega a las facturas existentes la fecha de compra/venta; como respaldo inicial
-- usa su fecha de vencimiento o pago anterior.
USE urmercados;
ALTER TABLE cuenta_proveedor ADD COLUMN fecha_factura DATE NULL AFTER forma_pago;
UPDATE cuenta_proveedor SET fecha_factura=fecha_pago WHERE fecha_factura IS NULL;
ALTER TABLE cuenta_proveedor MODIFY fecha_factura DATE NOT NULL;
ALTER TABLE cuenta_cliente ADD COLUMN fecha_factura DATE NULL AFTER forma_pago;
UPDATE cuenta_cliente SET fecha_factura=fecha_cobro WHERE fecha_factura IS NULL;
ALTER TABLE cuenta_cliente MODIFY fecha_factura DATE NOT NULL;
