# Brățări pentru Copii - Platformă Multi-Tenant

## Descriere

Platformă web multi-tenant pentru urmărirea timpului petrecut de copii folosind brățări RFID (în POC – simulate prin coduri random).

## Funcționalități Implementate

### ✅ Completate
- **Configurare Laravel** cu autentificare și multi-tenancy
- **Baza de date** cu toate entitățile necesare
- **Modele Eloquent** cu relații și validări
- **Sistem autentificare** cu roluri (SUPER_ADMIN, COMPANY_ADMIN, STAFF)
- **Dashboard CRM** cu statistici relevante și acțiuni rapide
- **Pagina de scanare brățară** cu generare cod RFID și gestionare sesiuni
- **Tabel cu copii** și sesiunile lor active cu butoane de start/stop
- **Formulare complete** pentru adăugare/editare copii și părinți
- **CRUD complet** pentru copii, părinți și brățări cu multi-tenancy
- **Sistem scanare POC** cu generare cod random și validare TTL
- **Gestionare sesiuni** cu cronometrare și start/stop
- **Interfață completă** cu navigație și design modern

### 🔄 În dezvoltare
- Sistem audit pentru acțiuni critice
- Rapoarte și statistici avansate
- Notificări în timp real
- Export date și rapoarte

## Instalare și Configurare

### Cerințe
- PHP 8.1+
- Composer
- SQLite (sau MySQL/PostgreSQL)

### Pași de instalare

1. **Clonează repository-ul**
```bash
git clone <repository-url>
cd bracelet-tracker
```

2. **Instalează dependențele**
```bash
composer install
```

3. **Configurează mediul**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Configurează baza de date**
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

5. **Rulează migrările și seederele**
```bash
php artisan migrate
php artisan db:seed
```

6. **Pornește serverul**
```bash
php artisan serve
```

## Utilizare

### Autentificare

**Super Administrator creat automat:**
- Email: `admin@bracelet-tracker.com`
- Parolă: `admin123`

### API Endpoints

#### Autentificare
- `POST /api/login` - Login utilizator
- `GET /api/user` - Informații utilizator autentificat
- `POST /api/logout` - Logout utilizator
- `POST /api/change-password` - Schimbă parola

#### Scanare (POC)
- `POST /api/scan/generate` - Generează cod random
- `POST /api/scan/validate` - Validează cod
- `GET /api/scan/recent` - Scanări recente
- `GET /api/scan/stats` - Statistici
- `POST /api/scan/cleanup` - Curăță coduri expirate

### Exemplu de utilizare API

#### 1. Login
```bash
curl -X POST http://localhost:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "admin@bracelet-tracker.com",
    "password": "admin123"
  }'
```

#### 2. Generează cod de scanare
```bash
curl -X POST http://localhost:8000/api/scan/generate \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json"
```

#### 3. Validează cod
```bash
curl -X POST http://localhost:8000/api/scan/validate \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "code": "ABC1234567"
  }'
```

## Structura Proiectului

```
app/
├── Http/Controllers/
│   ├── AuthController.php      # Autentificare
│   └── ScanController.php      # Scanare POC
├── Models/
│   ├── User.php               # Utilizatori
│   ├── Role.php               # Roluri
│   ├── Tenant.php             # Companii/Tenants
│   ├── Guardian.php           # Tutori
│   ├── Child.php              # Copii
│   ├── Bracelet.php           # Brățări
│   ├── ScanEvent.php          # Evenimente scanare
│   └── AuditLog.php           # Loguri audit
└── Services/
    └── ScanService.php        # Serviciu scanare

database/
├── migrations/                # Migrări baza de date
└── seeders/                   # Date inițiale
    ├── RoleSeeder.php
    └── SuperAdminSeeder.php

routes/
└── api.php                   # Rute API
```

## Configurare Multi-Tenant

Sistemul suportă multi-tenancy prin:
- `tenant_id` în toate entitățile relevante
- SUPER_ADMIN nu are `tenant_id` (acces global)
- COMPANY_ADMIN și STAFF sunt legați de un tenant specific

## Roluri Utilizatori

- **SUPER_ADMIN**: Acces global, poate crea companii
- **COMPANY_ADMIN**: Administrator companie, gestionează utilizatori/copii/brățări
- **STAFF**: Angajat, poate face scanări și gestiona copii/brățări

## Sistem Scanare POC

- **Generare cod**: 10 caractere, charset fără O/0, I/1
- **TTL**: 60 secunde
- **Unicitate**: Garantată per tenant în intervalul TTL
- **Validare**: Verifică existența și expirarea codului

## Dezvoltare Viitoare

1. **CRUD Controllers** pentru toate entitățile
2. **Dashboard** cu statistici și scanări recente
3. **Sistem Audit** pentru acțiuni critice
4. **Frontend React** cu interfață modernă
5. **Integrare RFID** reală (în loc de coduri random)
6. **Raportare avansată** și export date

## Testare

```bash
# Rulează testele
php artisan test

# Curăță coduri expirate
php artisan tinker
>>> app(App\Services\ScanService::class)->cleanupExpiredCodes();
```

## Contribuții

1. Fork repository-ul
2. Creează branch pentru feature (`git checkout -b feature/AmazingFeature`)
3. Commit modificările (`git commit -m 'Add some AmazingFeature'`)
4. Push la branch (`git push origin feature/AmazingFeature`)
5. Deschide Pull Request

## Licență

Acest proiect este licențiat sub MIT License.