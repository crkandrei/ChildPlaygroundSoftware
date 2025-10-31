<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'SUPER_ADMIN',
                'display_name' => 'Super Administrator',
                'description' => 'Administrator global cu acces la toate funcționalitățile sistemului',
            ],
            [
                'name' => 'COMPANY_ADMIN',
                'display_name' => 'Administrator Companie',
                'description' => 'Administrator al unei companii cu acces la toate datele companiei',
            ],
            [
                'name' => 'STAFF',
                'display_name' => 'Angajat',
                'description' => 'Angajat cu acces limitat la funcționalitățile de bază',
            ],
        ];

        foreach ($roles as $role) {
            Role::updateOrCreate(
                ['name' => $role['name']],
                $role
            );
        }
    }
}
