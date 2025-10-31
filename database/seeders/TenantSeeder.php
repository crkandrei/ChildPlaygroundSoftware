<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class TenantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Creează sau găsește primul tenant - Grădinița Florișoarele
        $tenant1 = Tenant::firstOrCreate(
            ['slug' => 'gradinita-florisoarele'],
            [
                'name' => 'Grădinița "Florișoarele"',
                'email' => 'contact@florisoarele.ro',
                'phone' => '021 123 4567',
                'address' => 'Strada Primăverii nr. 10, București',
                'is_active' => true,
            ]
        );

        // Creează sau găsește al doilea tenant - BongoLand
        $tenant2 = Tenant::firstOrCreate(
            ['slug' => 'bongoland'],
            [
                'name' => 'BongoLand',
                'email' => 'contact@bongoland.ro',
                'phone' => '021 987 6543',
                'address' => 'Bulevardul Bongo nr. 25, București',
                'is_active' => true,
            ]
        );

        // Găsește rolurile
        $companyAdminRole = Role::where('name', 'COMPANY_ADMIN')->first();
        $staffRole = Role::where('name', 'STAFF')->first();

        if ($companyAdminRole) {
            // Creează sau găsește company admin pentru Grădinița Florișoarele
            User::firstOrCreate(
                ['email' => 'maria@florisoarele.ro'],
                [
                    'name' => 'Maria Popescu',
                    'password' => Hash::make('admin123'),
                    'tenant_id' => $tenant1->id,
                    'role_id' => $companyAdminRole->id,
                    'status' => 'active',
                    'email_verified_at' => now(),
                ]
            );

            // Creează sau găsește company admin pentru BongoLand
            User::firstOrCreate(
                ['email' => 'alex@bongoland.ro'],
                [
                    'name' => 'Alexandru Bongo',
                    'password' => Hash::make('bongo123'),
                    'tenant_id' => $tenant2->id,
                    'role_id' => $companyAdminRole->id,
                    'status' => 'active',
                    'email_verified_at' => now(),
                ]
            );
        }

        if ($staffRole) {
            // Creează sau găsește staff pentru Grădinița Florișoarele
            User::firstOrCreate(
                ['email' => 'ion@florisoarele.ro'],
                [
                    'name' => 'Ion Ionescu',
                    'password' => Hash::make('staff123'),
                    'tenant_id' => $tenant1->id,
                    'role_id' => $staffRole->id,
                    'status' => 'active',
                    'email_verified_at' => now(),
                ]
            );

            // Creează sau găsește staff pentru BongoLand
            User::firstOrCreate(
                ['email' => 'elena@bongoland.ro'],
                [
                    'name' => 'Elena Bongo',
                    'password' => Hash::make('bongo123'),
                    'tenant_id' => $tenant2->id,
                    'role_id' => $staffRole->id,
                    'status' => 'active',
                    'email_verified_at' => now(),
                ]
            );
        }

        $this->command->info('Tenanți creați cu succes!');
        $this->command->info('=== Grădinița Florișoarele ===');
        $this->command->info('Company Admin: maria@florisoarele.ro / admin123');
        $this->command->info('Staff: ion@florisoarele.ro / staff123');
        $this->command->info('=== BongoLand ===');
        $this->command->info('Company Admin: alex@bongoland.ro / bongo123');
        $this->command->info('Staff: elena@bongoland.ro / bongo123');
    }
}
