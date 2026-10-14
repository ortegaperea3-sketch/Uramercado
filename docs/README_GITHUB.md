# Uramercados — Estructura para GitHub

## Repositorio
Nombre recomendado: `uramercados-fase-ii`

## Estructura
```text
uramercados-fase-ii/
├── .github/
│   ├── workflows/php-lint.yml
│   └── ISSUE_TEMPLATE/bug_report.md
├── css/
│   └── style.css
├── config/
│   ├── auth.php
│   └── config.php
├── db/
│   └── urmercados.sql
├── docs/
│   ├── capturas/
│   ├── demo/
│   ├── pruebas/
│   ├── README_GITHUB.md
│   ├── INSTALACION.md
│   └── EVIDENCIAS.md
├── partials/
│   ├── footer.php
│   └── header.php
├── js/
│   └── app.js
├── categorias.php
├── dashboard.php
├── historial.php
├── index.php
├── inventario.php
├── logout.php
├── movimiento.php
├── productos.php
├── reporte.php
├── README.md
└── .gitignore
```

## Flujo Git recomendado
```bash
git init
git add .
git commit -m "feat: entrega fase II Uramercados"
git branch -M main
git remote add origin URL_DEL_REPOSITORIO
git push -u origin main
```

No publiques contraseñas reales, credenciales de producción, archivos `.env` ni datos personales.
