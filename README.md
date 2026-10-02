# NewsPortal

Uudisteportaal PHP-s (MVC-struktuur, ilma raamistikuta). Õppeprojekt.

## Mis on olemas

Avalik sait:
- avaleht (kolm viimast uudist), kõik uudised, uudised kategooria kaupa
- ühe uudise vaatamine ja kommentaarid (lisamine, nimekiri, kommentaaride arv)
- kasutaja registreerimine (`registerForm`)
- 404 leht

Admin-paneel (`/admin/`):
- sisselogimine e-posti ja parooliga, väljalogimine
- uudiste nimekiri, lisamine, muutmine ja kustutamine (ainult staatusega `admin`)

## Struktuur

| Kaust / fail | Roll |
|---|---|
| `index.php`, `route/`, `controller/`, `model/`, `view/` | avalik sait |
| `admin/index.php`, `admin/routeAdmin/`, `admin/controllerAdmin/`, `admin/modelAdmin/`, `admin/viewAdmin/` | admin-paneel |
| `inc/Database.php` | ühendus andmebaasiga (PDO), ühine mõlemale |
| `public/`, `admin/public/` | Bootstrap 3, Font Awesome, jQuery |
| `newsportal.sql` | andmebaasi struktuur ja testandmed |

## Käivitamine

1. Vaja on Apache + PHP 8 (`mod_rewrite` sees, `AllowOverride All`) ja MySQL 8. Mina kasutasin Docker LAMP keskkonda (php:8.2-apache, mysql:8.0, phpMyAdmin).
2. Pane projekt kausta, mida Apache serveerib (minul `www/NewsPortal`).
3. Impordi `newsportal.sql`. See loob andmebaasi `NewsPortal` ja testandmed.
4. Vajadusel muuda seaded failis `inc/Database.php` (host, kasutaja, parool, andmebaas). Praegu on host `db` (Dockeri teenuse nimi), kasutaja `root`, parool `root`. XAMPP-i puhul on host `localhost`.
5. Ava `http://localhost:8080/NewsPortal/` ja admin-paneel `http://localhost:8080/NewsPortal/admin/`.

## Testkasutajad

| E-post | Parool | Staatus |
|---|---|---|
| admin@newsportal.ee | 123456 | admin |
| user@newsportal.ee | 111111 | user |
