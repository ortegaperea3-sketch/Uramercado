<?php
declare(strict_types=1);
require_once __DIR__.'/config.php';
function require_login(): void { if(empty($_SESSION['user'])) redirect('index.php'); }
function require_admin(): void { require_login(); if(($_SESSION['user']['rol']??'')!=='propietario'){ http_response_code(403); exit('Acceso no autorizado.'); } }
function current_user(): array { return $_SESSION['user']??[]; }
