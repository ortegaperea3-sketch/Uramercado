<?php
require_once 'config/auth.php';
require_admin();
$pageTitle = 'Clientes y proveedores';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tipo = $_POST['tipo'] ?? '';
    $nombre = trim($_POST['nombre'] ?? '');
    $telefono = trim($_POST['telefono'] ?? '');
    if ($nombre === '' || !in_array($tipo, ['proveedor','cliente'], true)) {
        flash('danger', 'Escribe un nombre y selecciona el tipo de tercero.');
    } elseif ($tipo === 'proveedor') {
        $email = trim($_POST['email'] ?? '');
        $pdo->prepare('INSERT INTO proveedor(nombre,telefono,email) VALUES(?,?,?)')->execute([$nombre,$telefono,$email ?: null]);
        flash('success', 'Proveedor agregado.');
    } else {
        $pdo->prepare('INSERT INTO cliente(nombre,telefono) VALUES(?,?)')->execute([$nombre,$telefono]);
        flash('success', 'Cliente agregado.');
    }
    redirect('terceros.php');
}
$proveedores=$pdo->query('SELECT nombre,telefono,email FROM proveedor WHERE estado=1 ORDER BY nombre')->fetchAll();
$clientes=$pdo->query('SELECT nombre,telefono FROM cliente WHERE estado=1 ORDER BY nombre')->fetchAll();
require 'partials/header.php'; ?>
<div class="page-head"><div><span class="eyebrow">CONTACTOS</span><h1>Clientes y proveedores</h1><p>Organiza los datos de las personas y empresas vinculadas a tus compras y ventas.</p></div></div>
<div class="panel contact-form-panel"><div class="panel-head"><div><span class="eyebrow">NUEVO REGISTRO</span><h2>Agregar cliente o proveedor</h2></div></div><form method="post" class="form form-grid"><label>Tipo de contacto<select name="tipo"><option value="proveedor">Proveedor</option><option value="cliente">Cliente</option></select></label><label>Nombre o razón social<input name="nombre" required maxlength="120" placeholder="Escribe el nombre"></label><label>Teléfono<input name="telefono" maxlength="50" placeholder="Número de contacto"></label><label>Correo electrónico <span class="muted">(opcional)</span><input type="email" name="email" maxlength="120" placeholder="correo@ejemplo.com"></label><button class="btn primary" type="submit"><span aria-hidden="true">＋</span> Guardar contacto</button></form></div>
<div class="two-col"><section class="panel"><div class="panel-head"><h2>Proveedores</h2></div><?php if(!$proveedores):?><div class="empty">Aún no hay proveedores.</div><?php else:?><div class="table-wrap"><table><thead><tr><th>Nombre</th><th>Teléfono</th><th>Correo</th></tr></thead><tbody><?php foreach($proveedores as $p):?><tr><td><?=e($p['nombre'])?></td><td><?=e($p['telefono'])?></td><td><?=e($p['email'])?></td></tr><?php endforeach;?></tbody></table></div><?php endif;?></section><section class="panel"><div class="panel-head"><h2>Clientes</h2></div><?php if(!$clientes):?><div class="empty">Aún no hay clientes.</div><?php else:?><div class="table-wrap"><table><thead><tr><th>Nombre</th><th>Teléfono</th></tr></thead><tbody><?php foreach($clientes as $c):?><tr><td><?=e($c['nombre'])?></td><td><?=e($c['telefono'])?></td></tr><?php endforeach;?></tbody></table></div><?php endif;?></section></div>
<?php require 'partials/footer.php'; ?>
