<?php

namespace Database\Seeders;

use App\Models\Tenant;
use Illuminate\Database\Seeder;

class TenantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Creează sau găsește tenant-ul BongoLand
        Tenant::firstOrCreate(
            ['slug' => 'bongoland'],
            [
                'name' => 'BongoLand',
                'email' => 'contact@bongoland.ro',
                'phone' => '021 987 6543',
                'address' => 'Bulevardul Bongo nr. 25, București',
                'is_active' => true,
            ]
        );

        $this->command->info('Tenant BongoLand creat cu succes!');
    }
}
