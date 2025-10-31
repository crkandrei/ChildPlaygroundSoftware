# 🔐 Credențiale de Testare - Brățări CRM

## Super Admin (Acces Global)
- **Email**: `admin@bracelet-tracker.com`
- **Parolă**: `admin123`
- **Rol**: SUPER_ADMIN
- **Acces**: Toate tenant-urile și funcționalitățile

## Grădinița "Florișoarele"

### Company Admin
- **Email**: `maria@florisoarele.ro`
- **Parolă**: `admin123`
- **Rol**: COMPANY_ADMIN
- **Acces**: Gestionare completă a tenant-ului

### Staff
- **Email**: `ion@florisoarele.ro`
- **Parolă**: `staff123`
- **Rol**: STAFF
- **Acces**: Operațiuni de zi cu zi

## BongoLand

### Company Admin
- **Email**: `alex@bongoland.ro`
- **Parolă**: `bongo123`
- **Rol**: COMPANY_ADMIN
- **Acces**: Gestionare completă a tenant-ului

### Staff
- **Email**: `elena@bongoland.ro`
- **Parolă**: `bongo123`
- **Rol**: STAFF
- **Acces**: Operațiuni de zi cu zi

## 🚀 Cum să testezi aplicația:

1. **Accesează**: http://localhost:8000
2. **Alege un utilizator** din lista de mai sus
3. **Login** cu credențialele respective
4. **Explorează funcționalitățile**:
   - Dashboard cu statistici
   - Scanare brățară RFID
   - Gestionare copii și sesiuni
   - Gestionare părinți
   - Gestionare brățări

## 📱 Funcționalități disponibile:

### Pentru toți utilizatorii:
- Dashboard cu statistici relevante
- Scanare brățară RFID (generare cod și validare)
- Vizualizare copii și sesiuni active
- Start/stop sesiuni cu cronometrare

### Pentru COMPANY_ADMIN și SUPER_ADMIN:
- Adăugare/editare/ștergere copii
- Adăugare/editare/ștergere părinți
- Gestionare brățări RFID
- Acces la toate funcționalitățile

### Pentru SUPER_ADMIN:
- Acces la toate tenant-urile
- Gestionare globală a sistemului

## 🎨 Design Features:
- **Admin Panel Modern** cu sidebar și navigație intuitivă
- **Design Responsive** pentru desktop și mobile
- **Iconițe FontAwesome** pentru o interfață profesională
- **Carduri cu hover effects** și animații subtile
- **Culori și gradiente** moderne
- **Feedback vizual** pentru toate acțiunile

## 🔧 Tehnologii:
- **Backend**: Laravel 11 cu PHP 8.4
- **Frontend**: Blade templates cu Tailwind CSS
- **Database**: SQLite (pentru dezvoltare)
- **Icons**: FontAwesome 6.0
- **Multi-tenancy**: Complet implementat

