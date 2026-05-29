# Rent A Car - PHP + MySQL

Sistem i plotë për rent a car me PHP 8+ dhe MySQL.

## Instalimi
1. Kopjo folderin në `htdocs` (XAMPP) ose `www` (WAMP).
2. Krijo databazën duke importuar `database.sql` në phpMyAdmin.
3. Konfiguro `config/db.php` me të dhënat e MySQL.
4. Hap `http://localhost/rentacar/`.

## Admin
- URL: `/admin/login.php`
- Email: `admin@rentacar.al`
- Fjalëkalimi: `admin123`

## Funksionalitete
- Lista e makinave me filtër (marka, çmimi)
- Detajet e makinës
- Formular rezervimi (data fillimi/mbarimi, llogaritja automatike e çmimit)
- Panel admin: shto/edito/fshi makina, menaxho rezervimet
- Login admin me sesion + bcrypt
- Upload fotosh