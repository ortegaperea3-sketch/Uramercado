<?php
require_once 'config/auth.php';
require_admin();
$pageTitle = 'Facturas, cobros y pagos';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accion = $_POST['accion'] ?? '';
    try {
        if ($accion === 'registrar') {
            $tipo = $_POST['tipo'] ?? '';
            $tercero = explode(':', $_POST['tercero'] ?? '', 2);
            $tipoTercero = $tercero[0] ?? '';
            $idTercero = isset($tercero[1]) ? filter_var($tercero[1], FILTER_VALIDATE_INT) : false;
            $factura = trim($_POST['numero_factura'] ?? '');
            $concepto = trim($_POST['concepto'] ?? '');
            $valor = filter_var($_POST['valor'] ?? null, FILTER_VALIDATE_FLOAT);
            $forma = $_POST['forma_pago'] ?? '';
            $fechaFactura = $_POST['fecha_factura'] ?? '';
            $fecha = $_POST['fecha_vencimiento'] ?? '';
            if (!in_array($tipo, ['pagar', 'cobrar'], true) || $tipoTercero !== ($tipo === 'pagar' ? 'proveedor' : 'cliente') || !$idTercero || $factura === '' || $concepto === '' || $valor === false || $valor <= 0 || !in_array($forma, ['contado', 'credito'], true) || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $fechaFactura) || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $fecha)) {
                throw new RuntimeException('Completa todos los campos con valores válidos.');
            }
            if ($tipo === 'pagar') {
                $stmt = $pdo->prepare("INSERT INTO cuenta_proveedor(numero_factura,id_proveedor,concepto,valor,forma_pago,fecha_factura,fecha_pago,estado) VALUES(?,?,?,?,?,?,?,?)");
                $stmt->execute([$factura, $idTercero, $concepto, $valor, $forma, $fechaFactura, $fecha, $forma === 'contado' ? 'pagado' : 'pendiente']);
            } else {
                $stmt = $pdo->prepare("INSERT INTO cuenta_cliente(numero_factura,id_cliente,concepto,valor,forma_pago,fecha_factura,fecha_cobro,estado) VALUES(?,?,?,?,?,?,?,?)");
                $stmt->execute([$factura, $idTercero, $concepto, $valor, $forma, $fechaFactura, $fecha, $forma === 'contado' ? 'cobrado' : 'pendiente']);
            }
            flash('success', $forma === 'contado' ? 'Factura de contado registrada.' : 'Factura a crédito registrada en cuentas pendientes.');
        } elseif ($accion === 'cerrar') {
            $tipo = $_POST['tipo'] ?? '';
            $id = filter_var($_POST['id'] ?? null, FILTER_VALIDATE_INT);
            if (!$id || !in_array($tipo, ['pagar', 'cobrar'], true)) throw new RuntimeException('La cuenta seleccionada no es válida.');
            if ($tipo === 'pagar') $pdo->prepare("UPDATE cuenta_proveedor SET estado='pagado' WHERE id_cuenta=? AND estado='pendiente'")->execute([$id]);
            else $pdo->prepare("UPDATE cuenta_cliente SET estado='cobrado' WHERE id_cuenta=? AND estado='pendiente'")->execute([$id]);
            flash('success', $tipo === 'pagar' ? 'Pago registrado.' : 'Cobro registrado.');
        } else {
            throw new RuntimeException('Acción no válida.');
        }
    } catch (Throwable $error) {
        flash('danger', $error instanceof PDOException ? 'No se pudo guardar. Verifica que el tercero exista y vuelve a intentarlo.' : $error->getMessage());
    }
    redirect('finanzas.php');
}

$proveedores = $pdo->query("SELECT id_proveedor id,nombre FROM proveedor WHERE estado=1 ORDER BY nombre")->fetchAll();
$clientes = $pdo->query("SELECT id_cliente id,nombre FROM cliente WHERE estado=1 ORDER BY nombre")->fetchAll();
$alertas = $pdo->query("SELECT 'pagar' tipo, cp.id_cuenta, cp.numero_factura, p.nombre tercero, cp.concepto, cp.valor, cp.fecha_pago fecha FROM cuenta_proveedor cp JOIN proveedor p ON p.id_proveedor=cp.id_proveedor WHERE cp.estado='pendiente' AND cp.fecha_pago<=DATE_ADD(CURDATE(),INTERVAL 3 DAY)
UNION ALL SELECT 'cobrar', cc.id_cuenta, cc.numero_factura, c.nombre, cc.concepto, cc.valor, cc.fecha_cobro FROM cuenta_cliente cc JOIN cliente c ON c.id_cliente=cc.id_cliente WHERE cc.estado='pendiente' AND cc.fecha_cobro<=DATE_ADD(CURDATE(),INTERVAL 3 DAY) ORDER BY fecha")->fetchAll();
$cuentas = $pdo->query("SELECT 'pagar' tipo, cp.id_cuenta, cp.numero_factura, p.nombre tercero, cp.concepto, cp.valor, cp.forma_pago, cp.fecha_factura, cp.fecha_pago fecha, cp.estado FROM cuenta_proveedor cp JOIN proveedor p ON p.id_proveedor=cp.id_proveedor
UNION ALL SELECT 'cobrar', cc.id_cuenta, cc.numero_factura, c.nombre, cc.concepto, cc.valor, cc.forma_pago, cc.fecha_factura, cc.fecha_cobro, cc.estado FROM cuenta_cliente cc JOIN cliente c ON c.id_cliente=cc.id_cliente ORDER BY fecha DESC")->fetchAll();
$pendientePagar = $pdo->query("SELECT COALESCE(SUM(valor),0) total FROM cuenta_proveedor WHERE estado='pendiente'")->fetch()['total'];
$pendienteCobrar = $pdo->query("SELECT COALESCE(SUM(valor),0) total FROM cuenta_cliente WHERE estado='pendiente'")->fetch()['total'];
require 'partials/header.php';
?>
<div class="page-head"><div><span class="eyebrow">FACTURAS Y CARTERA</span><h1>Facturas, cobros y pagos</h1><p>Registra facturas de compra y venta. Las facturas a crédito pendientes aparecen en la alarma desde tres días antes de su vencimiento.</p></div></div>
<section class="stats"><div class="stat warning"><span>Por pagar a proveedores</span><strong>$<?=number_format((float)$pendientePagar,0,',','.')?></strong></div><div class="stat"><span>Por cobrar a clientes</span><strong>$<?=number_format((float)$pendienteCobrar,0,',','.')?></strong></div><div class="stat warning"><span>Alarmas próximas o vencidas</span><strong><?=count($alertas)?></strong></div></section>
<div class="panel" style="margin-bottom:22px"><div class="panel-head"><h2>🔔 Alarmas de los próximos 3 días y vencidas</h2></div>
<?php if (!$alertas): ?><div class="empty">No hay cuentas pendientes próximas a vencer.</div><?php else: ?><div class="table-wrap"><table><thead><tr><th>Acción</th><th>Factura</th><th>Cliente o proveedor</th><th>Concepto</th><th>Valor</th><th>Vencimiento</th><th></th></tr></thead><tbody>
<?php foreach ($alertas as $a): $dias=(int)floor((strtotime($a['fecha'])-strtotime(date('Y-m-d')))/86400); ?><tr><td><span class="badge <?=$a['tipo']==='pagar'?'danger':'info'?>"><?=$a['tipo']==='pagar'?'Pagar':'Cobrar'?></span></td><td><?=e($a['numero_factura'])?></td><td><?=e($a['tercero'])?></td><td><?=e($a['concepto'])?></td><td>$<?=number_format((float)$a['valor'],0,',','.')?></td><td><?=e(date('d/m/Y',strtotime($a['fecha'])))?> · <?=$dias<0?'Vencida':($dias===0?'Hoy':'En '.$dias.' días')?></td><td><form method="post"><input type="hidden" name="accion" value="cerrar"><input type="hidden" name="tipo" value="<?=e($a['tipo'])?>"><input type="hidden" name="id" value="<?=$a['id_cuenta']?>"><button class="btn secondary" type="submit"><?=$a['tipo']==='pagar'?'Registrar pago':'Registrar cobro'?></button></form></td></tr><?php endforeach; ?></tbody></table></div><?php endif; ?></div>
<div class="panel" style="margin-bottom:22px"><div class="panel-head"><h2>Registrar factura</h2></div>
<form method="post" class="form form-grid"><input type="hidden" name="accion" value="registrar"><label>Tipo de factura<select name="tipo" required data-invoice-type><option value="pagar">Compra a proveedor (cuenta por pagar)</option><option value="cobrar">Venta a cliente (cuenta por cobrar)</option></select></label><label>Proveedor / cliente<select name="tercero" required data-invoice-party><option value="">Selecciona un tercero</option><optgroup label="Proveedores" data-party-type="pagar"><?php if(!$proveedores):?><option value="" disabled>No hay proveedores registrados</option><?php else:foreach($proveedores as $p):?><option value="proveedor:<?=$p['id']?>"><?=e($p['nombre'])?></option><?php endforeach;endif;?></optgroup><optgroup label="Clientes" data-party-type="cobrar"><?php if(!$clientes):?><option value="" disabled>No hay clientes registrados</option><?php else:foreach($clientes as $c):?><option value="cliente:<?=$c['id']?>"><?=e($c['nombre'])?></option><?php endforeach;endif;?></optgroup></select><?php if(!$proveedores || !$clientes):?><small class="party-help muted" data-party-help>Si no aparece el tercero que necesitas, agrégalo primero en <a href="terceros.php">Clientes y proveedores</a>.</small><?php endif;?></label><label>Número de factura<input name="numero_factura" maxlength="50" required placeholder="Ej. FV-00125"></label><label>Concepto / mercancía<input name="concepto" maxlength="200" required placeholder="Ej. Compra de arroz y aceite"></label><label>Valor<input type="number" name="valor" min="0.01" step="0.01" required></label><label>Forma de pago<select name="forma_pago" required><option value="credito">A crédito</option><option value="contado">De contado</option></select></label><label>Fecha de compra o venta<input type="date" name="fecha_factura" required value="<?=date('Y-m-d')?>"></label><label>Fecha de vencimiento o pago<input type="date" name="fecha_vencimiento" required value="<?=date('Y-m-d')?>"></label><button class="btn primary" type="submit">Guardar factura</button><p class="muted">Las facturas de contado quedan registradas como pagadas/cobradas. Las de crédito quedan pendientes hasta que registres el pago o cobro.</p></form></div>
<div class="panel"><div class="panel-head"><h2>Historial de facturas y cuentas</h2><a href="terceros.php">Administrar clientes y proveedores</a></div>
<?php if(!$cuentas):?><div class="empty">Aún no hay facturas registradas.</div><?php else:?><div class="table-wrap"><table><thead><tr><th>Tipo</th><th>Factura</th><th>Tercero</th><th>Concepto</th><th>Valor</th><th>Forma</th><th>Fecha de compra/venta</th><th>Vencimiento</th><th>Estado</th></tr></thead><tbody><?php foreach($cuentas as $c):?><tr><td><?=$c['tipo']==='pagar'?'Compra':'Venta'?></td><td><?=e($c['numero_factura'])?></td><td><?=e($c['tercero'])?></td><td><?=e($c['concepto'])?></td><td>$<?=number_format((float)$c['valor'],0,',','.')?></td><td><?=e(ucfirst($c['forma_pago']))?></td><td><?=e(date('d/m/Y',strtotime($c['fecha_factura'])))?></td><td><?=e(date('d/m/Y',strtotime($c['fecha'])))?></td><td><span class="badge <?=$c['estado']==='pendiente'?'warning':'success'?>"><?=e(ucfirst($c['estado']))?></span></td></tr><?php endforeach;?></tbody></table></div><?php endif;?></div>
<?php require 'partials/footer.php'; ?>
