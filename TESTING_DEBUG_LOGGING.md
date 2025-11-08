# 🧪 Ghid de Testare - Sistem de Debugging și Logging

## 1. Testare Laravel Telescope

### Acces la Telescope
1. **Pornește serverul** (dacă nu rulează deja):
   ```bash
   php artisan serve
   ```

2. **Loghează-te ca SUPER_ADMIN**:
   - Email: `admin@bracelet-tracker.com`
   - Parolă: `admin123`
   - Accesează: http://localhost:8000/login

3. **Accesează Telescope**:
   - După login, accesează: http://localhost:8000/telescope
   - Ar trebui să vezi dashboard-ul Telescope cu toate request-urile, queries, exceptions, etc.

### Testare acces restricționat
1. **Loghează-te cu un utilizator NON-ADMIN** (ex: `ion@florisoarele.ro`)
2. **Încearcă să accesezi**: http://localhost:8000/telescope
3. **Ar trebui să fii redirecționat** (403 Forbidden sau redirect către dashboard)

## 2. Testare Logging - Acțiuni importante

### Testare logging pentru scans
1. **Loghează-te** cu orice utilizator
2. **Accesează pagina de scanare**: http://localhost:8000/scan
3. **Generează un cod RFID** (click pe butonul de generare)
4. **Verifică logurile**:
   ```bash
   tail -f storage/logs/actions.log
   ```
   Ar trebui să vezi un log pentru `scan.created`

### Testare logging pentru sesiuni
1. **Pornește o sesiune** pentru un copil existent
2. **Pauzează sesiunea**
3. **Reia sesiunea**
4. **Oprește sesiunea**
5. **Verifică logurile**:
   ```bash
   tail -f storage/logs/actions.log | grep session
   ```
   Ar trebui să vezi: `session.started`, `session.paused`, `session.resumed`, `session.stopped`

### Testare logging pentru CRUD operations
1. **Creează un copil nou**:
   - Accesează: http://localhost:8000/children/create
   - Completează formularul și salvează
   - Verifică logurile: `tail -f storage/logs/actions.log | grep "Child.created"`

2. **Editează un copil**:
   - Accesează un copil existent → Edit
   - Modifică datele și salvează
   - Verifică logurile: `tail -f storage/logs/audit.log | grep "Child.updated"`
   - Verifică și în baza de date: `SELECT * FROM audit_logs ORDER BY id DESC LIMIT 5;`

3. **Șterge un copil** (dacă nu are sesiuni active):
   - Verifică logurile: `tail -f storage/logs/actions.log | grep "Child.deleted"`

4. **Repetă pentru Brățări și Părinți** (Bracelet, Guardian)

## 3. Testare Logging - Erori și Excepții

### Generare eroare intenționată
1. **Încearcă să accesezi o resursă inexistentă**:
   - http://localhost:8000/children/99999 (un ID inexistent)
   - Sau încearcă să ștergi un copil cu sesiuni active

2. **Verifică logurile de erori**:
   ```bash
   tail -f storage/logs/errors.log
   ```
   Ar trebui să vezi excepția cu context complet (user, tenant, request data, etc.)

### Verificare în Telescope
1. **Accesează Telescope** (ca SUPER_ADMIN)
2. **Click pe "Exceptions"** în sidebar
3. **Ar trebui să vezi** toate excepțiile cu detalii complete

## 4. Verificare fișiere de log

### Structura logurilor
- **`storage/logs/actions.log`** - Acțiuni importante (scans, sesiuni, CRUD)
- **`storage/logs/errors.log`** - Erori și excepții
- **`storage/logs/audit.log`** - Audit trail (acțiuni critice)
- **`storage/logs/laravel.log`** - Log general Laravel

### Comenzi utile pentru verificare
```bash
# Vezi ultimele 50 de linii din actions.log
tail -n 50 storage/logs/actions.log

# Monitorizează logurile în timp real
tail -f storage/logs/actions.log

# Caută o acțiune specifică
grep "session.started" storage/logs/actions.log

# Vezi logurile de astăzi
grep "$(date +%Y-%m-%d)" storage/logs/actions.log

# Numără acțiunile de astăzi
grep -c "$(date +%Y-%m-%d)" storage/logs/actions.log
```

## 5. Verificare în baza de date

### AuditLog entries
```bash
php artisan tinker
```
Apoi în tinker:
```php
\App\Models\AuditLog::latest()->take(10)->get();
```

### Telescope entries
```sql
SELECT * FROM telescope_entries ORDER BY created_at DESC LIMIT 10;
```

## 6. Checklist de testare completă

- [ ] Acces Telescope ca SUPER_ADMIN funcționează
- [ ] Acces Telescope ca NON-ADMIN este blocat
- [ ] Logging pentru scan codes (created, validated, expired)
- [ ] Logging pentru sesiuni (started, stopped, paused, resumed)
- [ ] Logging pentru CRUD Child (created, updated, deleted)
- [ ] Logging pentru CRUD Bracelet (created, updated, deleted)
- [ ] Logging pentru CRUD Guardian (created, updated, deleted)
- [ ] Logging pentru excepții apare în errors.log
- [ ] Excepții apar în Telescope
- [ ] AuditLog entries sunt create în baza de date
- [ ] Request logging middleware funcționează (POST/PUT/DELETE requests sunt loggate)

## 7. Debugging în timp real

### Folosind Laravel Pail (deja configurat)
```bash
# În terminal separat
php artisan pail
```
Acest comand va afișa toate logurile în timp real cu culori.

### Folosind Telescope Live
- Accesează Telescope și toate request-urile vor fi vizibile în timp real
- Poți filtra după URL, status code, method, etc.

## 8. Tips pentru debugging

1. **Folosește Telescope pentru debugging rapid**:
   - Vezi toate request-urile și răspunsurile
   - Vezi toate query-urile SQL executate
   - Vezi toate excepțiile cu stack trace complet

2. **Folosește logurile pentru audit și analiză**:
   - Logurile sunt structurate și ușor de căutat
   - Pot fi folosite pentru rapoarte și statistici

3. **Monitorizează errors.log în producție**:
   - Orice eroare va fi loggată automat cu context complet
   - Poți configura alerte bazate pe logurile de eroare

## 9. Testare scenarii specifice

### Scenario 1: Flow complet scanare
1. Generează cod RFID → Verifică `scan.created` în log
2. Scanează codul → Verifică `scan.validated` sau `scan.expired`
3. Asignează brățara copilului → Verifică logging în controller
4. Pornește sesiunea → Verifică `session.started`
5. Oprește sesiunea → Verifică `session.stopped` și `bracelet.unassigned`

### Scenario 2: CRUD complet
1. Creează părinte → Verifică `Guardian.created`
2. Creează copil → Verifică `Child.created`
3. Creează brățară → Verifică `Bracelet.created`
4. Editează copil → Verifică `Child.updated` în audit.log și baza de date
5. Șterge brățară → Verifică `Bracelet.deleted`

### Scenario 3: Erori
1. Încearcă să creezi copil fără părinte → Verifică eroare în errors.log
2. Încearcă să accesezi resursă inexistentă → Verifică eroare în Telescope
3. Încearcă operațiune nepermisă → Verifică eroare cu context complet



