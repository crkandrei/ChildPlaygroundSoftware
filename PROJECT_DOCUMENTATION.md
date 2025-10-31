# Brățări pentru Copii - Platformă Multi-Tenant

## Rezumat Executiv

„Brățări pentru copii" este o platformă web multi-tenant care permite locurilor de joacă să urmărească timpul petrecut de copii folosind brățări RFID (în POC – simulate prin coduri random).

POC-ul va valida fluxul de scanare/asignare, arhitectura multi-tenant și raportarea de bază, fără hardware real. Ulterior, sistemul va fi extins pentru integrarea cititoarelor RFID/NFC.

## Obiective & KPI POC

### Obiective:
- Validarea fluxului „scanare → copil → raport"
- Implementarea izolării multi-tenant (tenant_id)
- Testarea rolurilor minime: super admin, patron companie, angajat

### KPI:
- Generare scan în <200ms
- 100% unicitate cod în intervalul de 60s
- <1% erori CRUD la copii/brățări
- Dashboard cu copii activi și scanări recente

## Roluri Utilizatori

- **SUPER_ADMIN** – admin global, creează companii, vede tot
- **COMPANY_ADMIN** – patron companie, administrează propriii utilizatori/copii/brățări
- **STAFF** – angajat, poate face scanări și gestiona copii/brățări

## Cerințe Funcționale

### Scanare (POC)
- Buton „Scanare" → generateRandomCode()
- Validare cod (lungime, charset, unicitate TTL 60s)
- Creare ScanEvent
- Feedback UI (toast verde/roșu + listă scanări recente)

### Management Entități
- **Companii (Tenants)**: CRUD (numai de SUPER_ADMIN)
- **Utilizatori**: CRUD per tenant (admin/angajat)
- **Tutori (Guardians)**: CRUD minim (nume, telefon/email)
- **Copii**: CRUD, legat de tutore
- **Brățări**: CRUD, asignare/revocare copil
- **Audit**: log pentru acțiuni critice

## Model de Date

| Entitate | Câmpuri Cheie |
|----------|---------------|
| Tenant | id (PK), name, slug, created_at |
| Role | id (PK), name (SUPER_ADMIN, COMPANY_ADMIN, STAFF) |
| User | id, tenant_id (FK nullable), name, email, password_hash, role_id, status |
| Guardian | id, tenant_id, name, phone, email |
| Child | id, tenant_id, guardian_id, initials, internal_code (unic per tenant), notes |
| Bracelet | id, tenant_id, code (unic), child_id (FK nullable), status, assigned_at |
| ScanEvent | id, tenant_id, bracelet_id, child_id, code_used, status, scanned_at |
| AuditLog | id, tenant_id, user_id, action, entity_type, entity_id, data_before/after |

## Pagini/Screen-uri

1. **Login / Reset parolă**
2. **Dashboard Tenant** - Copii activi, scanări recente
3. **Scanare (POC)** - Buton scanare, validare, istoric
4. **Copii** - Listă + CRUD
5. **Brățări** - Listă + CRUD, asignare copil
6. **Tutori** - Listă + CRUD
7. **Utilizatori** - CRUD, asignare rol
8. **Audit** - Istoric acțiuni

## Fluxuri Principale

### Onboarding Companie
1. SUPER_ADMIN creează tenant
2. Creează COMPANY_ADMIN
3. COMPANY_ADMIN creează angajați, copii, brățări

### Asignare Brățară
1. Staff selectează copil
2. Click „Asignează brățară"
3. Introduce cod brățară → salvat + audit

### Scanare (POC)
1. Staff apasă „Scanare"
2. Backend → generateRandomCode() (10 caractere)
3. Validare unicitate & TTL
4. Creare ScanEvent
5. UI afișează feedback

## Generare Cod Random (POC)

- **Lungime**: 10 caractere
- **Charset**: A–Z, 2–9 (fără O/0, I/1)
- **TTL**: 60s
- **Unicitate**: per tenant

## Arhitectură

**POC**: Monolit Laravel + React
- Autentificare: Laravel Sanctum/JWT
- Multi-tenant: tenant_id în toate entitățile
- SUPER_ADMIN → tenant_id = NULL

## Criterii Acceptare POC

- [ ] Login funcțional cu 3 roluri
- [ ] Tenant CRUD doar de SUPER_ADMIN
- [ ] Copii/Tutori/Brățări CRUD funcțional
- [ ] Scanare cod random cu validare TTL
- [ ] Audit pentru acțiuni critice
- [ ] Dashboard afișează scanări recente

## Status Dezvoltare

- [ ] Configurare Laravel + React
- [ ] Setup baza de date + migrări
- [ ] Implementare autentificare + roluri
- [ ] CRUD entități de bază
- [ ] Sistem scanare POC
- [ ] Dashboard + raportare
- [ ] Testare + optimizare

---

**Ultima actualizare**: 2024-12-19
**Versiune**: POC v1.0
