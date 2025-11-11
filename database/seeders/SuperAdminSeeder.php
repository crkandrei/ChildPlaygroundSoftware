<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Găsește rolul de SUPER_ADMIN
        $superAdminRole = Role::where('name', 'SUPER_ADMIN')->first();

        if (!$superAdminRole) {
            $this->command->error('Rolul SUPER_ADMIN nu a fost găsit. Rulează mai întâi RoleSeeder.');
            return;
        }

        // Creează utilizatorul super admin
        User::updateOrCreate(
            ['username' => 'admin'],
            [
                'name' => 'Super Administrator',
                'username' => 'admin',
                'email' => 'admin@bracelet-tracker.com',
                'password' => Hash::make('admin123'),
                'role_id' => $superAdminRole->id,
                'status' => 'active',
                'email_verified_at' => now(),
            ]
        );

        $this->command->info('Super Administrator creat cu succes!');
        $this->command->info('Username: admin');
        $this->command->info('Parolă: admin123');
    }
}
