# Brățări pentru Copii - Platformă Multi-Tenant

## Descriere

Platformă web multi-tenant pentru urmărirea timpului petrecut de copii folosind brățări RFID (în POC – simulate prin coduri random). Sistemul permite gestionarea completă a sesiunilor de joacă, calcularea automată a prețurilor și generarea de rapoarte detaliate.

## Funcționalități Implementate

### ✅ Completate
- **Configurare Laravel 12** cu autentificare și multi-tenancy completă
- **Baza de date** cu toate entitățile necesare și migrări complete
- **Modele Eloquent** cu relații și validări
- **Sistem autentificare** cu roluri (SUPER_ADMIN, COMPANY_ADMIN, STAFF) și gestionare parolă
- **Dashboard CRM** cu statistici live și acțiuni rapide
- **Pagina de scanare brățară** cu generare cod RFID și gestionare sesiuni completă
- **Gestionare sesiuni de joacă** cu:
  - Start/stop/pause/resume
  - Cronometrare în timp real
  - Tracking precis prin intervale (PlaySessionInterval)
  - Calculare automată durată efectivă (exclusiv pauzele)
- **Sistem de pricing** cu:
  - Tarif pe oră configurabil per tenant
  - Calculare automată prețuri bazată pe durată efectivă
  - Rotunjire automată la 0.5 ore (minimum 0.5h)
  - Păstrare istoric prețuri (prețul la momentul calculării)
- **Rapoarte și statistici** cu:
  - Rapoarte detaliate per perioadă
  - Filtrare pe zilele săptămânii
  - Distribuție durată sesiuni (<1h, 1-2h, 2-3h, >3h)
  - Analiză trafic pe ore
  - Distribuție vizitatori (unici vs recurenți)
  - Vârsta medie copii
- **Generare bonuri/receipts** pentru sesiuni finalizate
- **CRUD complet** pentru copii, părinți și brățări cu multi-tenancy
- **Sistem scanare POC** cu generare cod random și validare TTL
- **Pagina de sesiuni** cu vizualizare, filtrare și detalii
- **Sistem audit** complet (ActionLogger) pentru acțiuni critice
- **Laravel Telescope** integrat pentru debugging și monitoring
- **Repositories pattern** pentru separare logică și testabilitate
- **Interfață completă** cu Blade templates, Tailwind CSS și navigație modernă

### 🔄 În dezvoltare
- Notificări în timp real
- Export date și rapoarte (PDF/Excel)
- Integrare RFID reală (în loc de coduri random)
- API publică pentru integrare cu aplicații mobile

## Instalare și Configurare

### Cerințe
- **PHP 8.2+** (testat cu PHP 8.4.12)
- **Composer**
- **Laravel Framework 12.x** (testat cu 12.28.1)
- **SQLite** (sau MySQL/PostgreSQL)
- **Node.js** și **npm** pentru frontend assets

### Pași de instalare

1. **Clonează repository-ul**
```bash
git clone <repository-url>
cd ChildPlaygroundSoftware
```

2. **Instalează dependențele PHP**
```bash
composer install
```

3. **Instalează dependențele Node.js**
```bash
npm install
```

4. **Configurează mediul**
```bash
cp .env.example .env
php artisan key:generate
```

5. **Configurează baza de date**
```bash
# Pentru SQLite (implicit)
touch database/database.sqlite

# Pentru MySQL/PostgreSQL, editează .env:
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=bracelet_tracker
# DB_USERNAME=root
# DB_PASSWORD=
```

6. **Rulează migrările și seederele**
```bash
php artisan migrate
php artisan db:seed
```

7. **Construiește frontend assets**
```bash
npm run build
# sau pentru development:
npm run dev
```

8. **Pornește serverul**
```bash
php artisan serve
```

Aplicația va fi disponibilă la `http://localhost:8000`

## Utilizare

### Autentificare

**Super Administrator creat automat:**
- Email: `admin@bracelet-tracker.com`
- Parolă: `admin123`

Pentru credențiale complete ale utilizatorilor de test, vezi fișierul `CREDENTIALS.md`.

### API Endpoints

#### Autentificare (Web)
- `GET /login` - Formular login
- `POST /login` - Autentificare utilizator
- `POST /logout` - Logout utilizator
- `GET /change-password` - Formular schimbare parolă
- `POST /change-password` - Schimbă parola

#### Dashboard
- `GET /dashboard` - Dashboard principal
- `GET /dashboard-api/stats` - Statistici dashboard (JSON)
- `GET /dashboard-api/active-sessions` - Sesiuni active (JSON)
- `GET /reports-api/activity` - Activitate recentă (JSON)
- `GET /reports-api/reports` - Rapoarte cu filtre (JSON)

#### Scanare și Sesiuni
- `POST /scan-api/generate` - Generează cod random pentru scanare
- `POST /scan-api/lookup` - Caută brățară după cod
- `POST /scan-api/assign` - Asignează brățară la copil
- `POST /scan-api/create-child` - Creează copil rapid
- `POST /scan-api/start-session` - Pornește sesiune de joacă
- `POST /scan-api/stop-session/{id}` - Oprește sesiune
- `POST /scan-api/pause-session/{id}` - Pune sesiune în pauză
- `POST /scan-api/resume-session/{id}` - Reia sesiune din pauză
- `GET /scan-api/active-sessions` - Listă sesiuni active
- `GET /scan-api/session-stats` - Statistici sesiuni
- `GET /scan-api/recent-completed` - Sesiuni completate recente
- `GET /scan-api/children-with-sessions` - Caută copii cu sesiuni active
- `GET /scan-api/child-session/{childId}` - Sesiunea activă a unui copil

#### Gestionare Entități
- `GET /children` - Listă copii
- `GET /children/data` - Date copii (JSON pentru DataTables)
- `GET /children-search` - Căutare copii
- `POST /children` - Creează copil
- `GET /children/{id}` - Detalii copil
- `PUT /children/{id}` - Actualizează copil
- `DELETE /children/{id}` - Șterge copil

- `GET /guardians` - Listă părinți/tutori
- `GET /guardians-data` - Date părinți (JSON)
- `GET /guardians-search` - Căutare părinți
- `POST /guardians` - Creează părinte
- `GET /guardians/{id}` - Detalii părinte
- `PUT /guardians/{id}` - Actualizează părinte
- `DELETE /guardians/{id}` - Șterge părinte

- `GET /bracelets` - Listă brățări
- `POST /bracelets` - Creează brățară
- `GET /bracelets/{id}` - Detalii brățară
- `PUT /bracelets/{id}` - Actualizează brățară
- `DELETE /bracelets/{id}` - Șterge brățară
- `POST /bracelets/{id}/unassign` - Dezasignează brățară de la copil

#### Sesiuni și Rapoarte
- `GET /sessions` - Listă sesiuni (read-only)
- `GET /sessions/data` - Date sesiuni (JSON)
- `GET /sessions/{id}/show` - Detalii sesiune
- `GET /sessions/{id}/receipt` - Bon/receipt pentru sesiune
- `GET /rapoarte` - Pagină rapoarte

#### Scanare Legacy (POC)
- `POST /api/scan/generate` - Generează cod random
- `POST /api/scan/validate` - Validează cod
- `GET /api/scan/recent` - Scanări recente
- `GET /api/scan/stats` - Statistici
- `POST /api/scan/cleanup` - Curăță coduri expirate

### Exemplu de utilizare API

#### 1. Login (Web Session)
```bash
curl -X POST http://localhost:8000/login \
  -H "Content-Type: application/x-www-form-urlencoded" \
  -d "email=admin@bracelet-tracker.com&password=admin123" \
  -c cookies.txt
```

#### 2. Obține statistici dashboard
```bash
curl -X GET http://localhost:8000/dashboard-api/stats \
  -b cookies.txt \
  -H "Accept: application/json"
```

#### 3. Pornește sesiune
```bash
curl -X POST http://localhost:8000/scan-api/start-session \
  -b cookies.txt \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "child_id": 1,
    "bracelet_id": 1
  }'
```

## Structura Proiectului

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── AuthController.php           # Autentificare web
│   │   ├── BraceletController.php       # CRUD brățări
│   │   ├── ChildController.php          # CRUD copii
│   │   ├── DashboardApiController.php   # API dashboard
│   │   ├── GuardianController.php       # CRUD părinți
│   │   ├── ReportsController.php        # Rapoarte
│   │   ├── ScanController.php           # Scanare POC legacy
│   │   ├── ScanPageController.php       # Scanare și sesiuni
│   │   ├── SessionsController.php      # Vizualizare sesiuni
│   │   └── WebController.php            # Controller web principal
│   ├── Middleware/
│   │   └── TenantMiddleware.php         # Middleware multi-tenant
│   └── Requests/
│       ├── StoreChildRequest.php        # Validare request copii
│       ├── UpdateChildRequest.php
│       ├── StoreGuardianRequest.php     # Validare request părinți
│       └── UpdateGuardianRequest.php
├── Models/
│   ├── AuditLog.php                     # Loguri audit
│   ├── Bracelet.php                    # Brățări
│   ├── Child.php                       # Copii
│   ├── Guardian.php                    # Tutori/Părinți
│   ├── PlaySession.php                 # Sesiuni de joacă
│   ├── PlaySessionInterval.php         # Intervale sesiuni (pentru pauze)
│   ├── Role.php                        # Roluri utilizatori
│   ├── ScanEvent.php                   # Evenimente scanare
│   ├── Tenant.php                      # Companii/Tenants
│   └── User.php                        # Utilizatori
├── Repositories/
│   ├── Contracts/
│   │   ├── ChildRepositoryInterface.php
│   │   ├── GuardianRepositoryInterface.php
│   │   ├── PlaySessionRepositoryInterface.php
│   │   └── BraceletRepositoryInterface.php
│   └── Eloquent/
│       ├── ChildRepository.php
│       ├── GuardianRepository.php
│       ├── PlaySessionRepository.php
│       └── BraceletRepository.php
├── Services/
│   ├── DashboardService.php            # Serviciu statistici dashboard
│   ├── PricingService.php              # Serviciu calculare prețuri
│   └── ScanService.php                 # Serviciu scanare POC
└── Support/
    ├── ActionLogger.php                # Logger pentru acțiuni critice
    └── ApiResponder.php               # Helper pentru răspunsuri API

database/
├── migrations/                         # Migrări baza de date
│   ├── create_users_table.php
│   ├── create_tenants_table.php
│   ├── create_children_table.php
│   ├── create_guardians_table.php
│   ├── create_bracelets_table.php
│   ├── create_play_sessions_table.php
│   ├── create_play_session_intervals_table.php
│   ├── create_scan_events_table.php
│   ├── create_audit_logs_table.php
│   └── ...
└── seeders/                            # Date inițiale
    ├── DatabaseSeeder.php
    ├── RoleSeeder.php
    ├── SuperAdminSeeder.php
    ├── TenantSeeder.php
    └── ...

resources/
├── views/                              # Blade templates
│   ├── layouts/
│   │   └── app.blade.php              # Layout principal
│   ├── auth/
│   │   └── login.blade.php            # Pagină login
│   ├── dashboard.blade.php           # Dashboard
│   ├── scan/
│   │   └── index.blade.php           # Pagină scanare
│   ├── sessions/
│   │   ├── index.blade.php           # Listă sesiuni
│   │   ├── show.blade.php            # Detalii sesiune
│   │   └── receipt.blade.php         # Bon sesiune
│   ├── children/                     # CRUD copii
│   ├── guardians/                    # CRUD părinți
│   ├── bracelets/                    # CRUD brățări
│   └── reports/
│       └── index.blade.php           # Rapoarte
├── css/
│   └── app.css                       # Stiluri Tailwind CSS
└── js/
    ├── app.js                        # JavaScript principal
    └── bootstrap.js

routes/
├── api.php                            # Rute API
└── web.php                            # Rute web

config/
├── telescope.php                     # Configurare Laravel Telescope
└── ...
```

## Configurare Multi-Tenant

Sistemul suportă multi-tenancy prin:
- `tenant_id` în toate entitățile relevante (children, guardians, bracelets, sessions, etc.)
- SUPER_ADMIN nu are `tenant_id` (acces global la toate tenant-urile)
- COMPANY_ADMIN și STAFF sunt legați de un tenant specific
- Middleware `TenantMiddleware` pentru izolarea automată a datelor
- Filtrare automată a query-urilor bazate pe rolul utilizatorului

## Roluri Utilizatori

- **SUPER_ADMIN**: Acces global, poate crea companii, vede toate tenant-urile
- **COMPANY_ADMIN**: Administrator companie, gestionează utilizatori/copii/brățări pentru tenant-ul său
- **STAFF**: Angajat, poate face scanări și gestiona copii/brățări pentru tenant-ul său

## Sistem Scanare POC

- **Generare cod**: 10 caractere, charset fără O/0, I/1
- **TTL**: 60 secunde
- **Unicitate**: Garantată per tenant în intervalul TTL
- **Validare**: Verifică existența și expirarea codului

## Sistem Sesiuni de Joacă

### Funcționalități
- **Start sesiune**: Se pornește o sesiune și un interval inițial
- **Pause**: Se închide intervalul curent (timpul nu se numără în durată)
- **Resume**: Se pornește un nou interval (timpul se numără din nou)
- **Stop**: Se închide intervalul curent și sesiunea, se calculează prețul

### Calculare Durată
- Durata efectivă = suma tuturor intervalelor închise
- Durata nu include pauzele (perioadele între intervale)
- Durata se afișează în timp real pe pagina de scanare

### Calculare Preț
- Preț = durată efectivă (ore) × tarif pe oră
- Durata se rotunjește în sus la cel mai apropiat 0.5 ore
- Minimum 0.5 ore per sesiune
- Prețul se calculează automat la stop și se salvează cu tariful folosit

## Tehnologii și Dependențe

### Backend
- **Laravel Framework 12.28.1**
- **PHP 8.4.12** (cerință minimă: PHP 8.2+)
- **Laravel Telescope 5.15** - Debugging și monitoring
- **Laravel Tinker** - Console interactivă

### Frontend
- **Blade Templates** - Templating engine Laravel
- **Tailwind CSS 4.0** - Framework CSS utility-first
- **Vite 7.0** - Build tool și dev server
- **Axios** - HTTP client pentru API calls
- **FontAwesome** - Iconițe

### Development Tools
- **Laravel Pail** - Log viewer în timp real
- **Laravel Pint** - Code style fixer
- **PHPUnit 11.5** - Testing framework
- **Concurrently** - Rulează mai multe procese simultan

### Scripts Composer
- `composer dev` - Pornește serverul, queue, logs și vite simultan
- `composer test` - Rulează testele PHPUnit

## Dezvoltare Viitoare

1. **Export rapoarte** în format PDF și Excel
2. **Notificări în timp real** pentru sesiuni active și evenimente
3. **API publică** pentru integrare cu aplicații mobile
4. **Integrare RFID reală** (cititoare RFID/NFC hardware)
5. **Plăți integrate** pentru sesiuni de joacă
6. **Aplicație mobile** pentru părinți (vizualizare sesiuni copii)
7. **Sistem de discounturi** și promoții
8. **Email notifications** pentru părinți (start/stop sesiuni)
9. **Dashboard analytics** avansat cu grafice interactive
10. **Multi-lingvă** (suport pentru mai multe limbi)

## Testare

```bash
# Rulează testele
php artisan test

# Curăță coduri expirate (tinker)
php artisan tinker
>>> app(App\Services\ScanService::class)->cleanupExpiredCodes();

# Accesează Laravel Telescope (doar în development)
# http://localhost:8000/telescope
```

## Debugging și Monitoring

### Laravel Telescope
Telescope este activat în modul development și oferă:
- Vizualizare requests HTTP
- Query-uri database
- Log entries
- Exceptions
- Queue jobs
- Cache operations

Acces: `http://localhost:8000/telescope`

### Laravel Pail
Pentru vizualizare logs în timp real:
```bash
php artisan pail
```

### Action Logger
Sistemul de logging pentru acțiuni critice:
- Loguri în `storage/logs/actions.log`
- Audit logs salvate în baza de date (`audit_logs` table)
- Context complet pentru fiecare acțiune

## Contribuții

1. Fork repository-ul
2. Creează branch pentru feature (`git checkout -b feature/AmazingFeature`)
3. Commit modificările (`git commit -m 'Add some AmazingFeature'`)
4. Push la branch (`git push origin feature/AmazingFeature`)
5. Deschide Pull Request

## Licență

Acest proiect este licențiat sub MIT License.
