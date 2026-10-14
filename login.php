<?php
require_once 'config/config.php';
if(!empty($_SESSION['user'])) redirect('dashboard.php');
$error=null;
if($_SERVER['REQUEST_METHOD']==='POST'){
 $usuario=trim($_POST['usuario']??''); $password=$_POST['password']??'';
 $st=$pdo->prepare('SELECT * FROM usuario WHERE usuario=? AND estado=1 LIMIT 1'); $st->execute([$usuario]); $u=$st->fetch();
 if($u && password_verify($password,$u['password_hash'])){ session_regenerate_id(true); $_SESSION['user']=$u; redirect('dashboard.php'); }
 $error='Usuario o contraseña incorrectos.';
}
?><!doctype html><html lang="es"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title><?=e(APP_NAME)?> | Acceso administrativo</title><link rel="stylesheet" href="css/style.css"></head><body class="login-page"><div class="login-shell"><div class="login-brand-side"><a class="brand login-brand" href="index.php"><span class="brand-mark">U</span><span>Uramercados</span></a><div><span class="eyebrow">GESTIÓN INTELIGENTE</span><h1>Controla tu inventario con claridad.</h1><p>Productos, existencias, movimientos y reportes en un solo lugar.</p></div><div class="login-points"><span>✓ Inventario actualizado</span><span>✓ Control por roles</span><span>✓ Reportes de gestión</span></div></div><section class="login-card"><div class="login-mobile-brand"><span class="brand-mark">U</span></div><span class="eyebrow">ACCESO AL SISTEMA</span><h2>Bienvenido nuevamente 👋</h2><p class="muted">Ingresa tus credenciales para continuar.</p><?php if($error):?><div class="alert danger"><?=e($error)?></div><?php endif;?><form method="post" class="form"><label>Usuario<input name="usuario" autocomplete="username" placeholder="Ingresa tu usuario" required></label><label>Contraseña<input type="password" name="password" autocomplete="current-password" placeholder="Ingresa tu contraseña" required></label><button class="btn primary full">Iniciar sesión</button></form><a class="back-store" href="index.php">← Volver a la tienda</a></section></div></body></html>
