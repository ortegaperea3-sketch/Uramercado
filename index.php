<?php require_once 'config/config.php';
if(!empty($_SESSION['user'])) redirect('dashboard.php');
$error=null;
if($_SERVER['REQUEST_METHOD']==='POST'){
 $usuario=trim($_POST['usuario']??''); $password=$_POST['password']??'';
 $st=$pdo->prepare('SELECT * FROM usuario WHERE usuario=? AND estado=1 LIMIT 1'); $st->execute([$usuario]); $u=$st->fetch();
 if($u && password_verify($password,$u['password_hash'])){ session_regenerate_id(true); $_SESSION['user']=$u; redirect('dashboard.php'); }
 $error='Usuario o contraseña incorrectos.';
}
?><!doctype html><html lang="es"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title><?=e(APP_NAME)?> | Acceso</title><link rel="stylesheet" href="css/style.css"></head><body class="login-page"><section class="login-card"><div class="brand-mark">U</div><h1>Uramercados</h1><p class="muted">Sistema web para la gestión de inventario</p><?php if($error):?><div class="alert danger"><?=e($error)?></div><?php endif;?><form method="post" class="form"><label>Usuario<input name="usuario" autocomplete="username" required></label><label>Contraseña<input type="password" name="password" autocomplete="current-password" required></label><button class="btn primary full">Iniciar sesión</button></form></section></body></html>

