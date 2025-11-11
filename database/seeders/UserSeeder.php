<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * Exemplu de utilizare:
     * php artisan db:seed --class=UserSeeder
     * 
     * Sau pentru un utilizator specific:
     * php artisan tinker
     * >>> UserSeeder::createUser('nume@email.com', 'Nume Utilizator', 'COMPANY_ADMIN', 'tenant-slug', 'parola123')
     */
    public function run(): void
    {
        $this->command->info('UserSeeder - Creează utilizatori pentru platformă');
        $this->command->info('Utilizare: php artisan db:seed --class=UserSeeder');
        $this->command->info('');
        $this->command->info('Pentru a crea utilizatori individuali, folosește tinker:');
        $this->command->info('php artisan tinker');
        $this->command->info('>>> $seeder = new \Database\Seeders\UserSeeder();');
        $this->command->info('>>> $seeder->createUser(\'email@example.com\', \'Nume\', \'COMPANY_ADMIN\', \'tenant-slug\', \'parola\');');
    }

    /**
     * Creează un utilizator nou
     * 
     * @param string $username Username-ul utilizatorului
     * @param string $name Numele utilizatorului
     * @param string $roleName Numele rolului (SUPER_ADMIN, COMPANY_ADMIN, STAFF)
     * @param string|null $tenantSlug Slug-ul tenant-ului (null pentru SUPER_ADMIN)
     * @param string $password Parola utilizatorului
     * @param string|null $email Email-ul utilizatorului (opțional)
     * @param string $status Statusul utilizatorului (default: 'active')
     * @return User
     */
    public function createUser(
        string $username,
        string $name,
        string $roleName,
        ?string $tenantSlug = null,
        string $password = 'password123',
        ?string $email = null,
        string $status = 'active'
    ): User {
        // Găsește rolul
        $role = Role::where('name', $roleName)->first();
        
        if (!$role) {
            throw new \Exception("Rolul '{$roleName}' nu a fost găsit. Rulează mai întâi RoleSeeder.");
        }

        // Pentru SUPER_ADMIN, tenant_id trebuie să fie null
        if ($roleName === 'SUPER_ADMIN') {
            $tenantId = null;
        } else {
            // Pentru alte roluri, găsește tenant-ul
            if (!$tenantSlug) {
                throw new \Exception("Pentru rolul '{$roleName}', trebuie să specifici un tenant slug.");
            }
            
            $tenant = Tenant::where('slug', $tenantSlug)->first();
            
            if (!$tenant) {
                throw new \Exception("Tenant-ul cu slug '{$tenantSlug}' nu a fost găsit.");
            }
            
            $tenantId = $tenant->id;
        }

        // Verifică dacă utilizatorul există deja
        $existingUser = User::where('username', $username)->first();
        
        if ($existingUser) {
            $this->command->warn("Utilizatorul cu username '{$username}' există deja. Actualizez datele...");
            
            $existingUser->update([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($password),
                'role_id' => $role->id,
                'tenant_id' => $tenantId,
                'status' => $status,
                'email_verified_at' => $email ? now() : null,
            ]);
            
            $this->command->info("Utilizator actualizat: {$username}");
            
            return $existingUser;
        }

        // Creează utilizatorul nou
        $user = User::create([
            'name' => $name,
            'username' => $username,
            'email' => $email,
            'password' => Hash::make($password),
            'role_id' => $role->id,
            'tenant_id' => $tenantId,
            'status' => $status,
            'email_verified_at' => $email ? now() : null,
        ]);

        $this->command->info("Utilizator creat cu succes!");
        $this->command->info("Username: {$username}");
        $this->command->info("Nume: {$name}");
        if ($email) {
            $this->command->info("Email: {$email}");
        }
        $this->command->info("Rol: {$role->display_name}");
        if ($tenantId) {
            $this->command->info("Tenant: {$tenantSlug}");
        }
        $this->command->info("Parolă: {$password}");

        return $user;
    }
}

