<?php

namespace Database\Seeders;

use App\Models\Child;
use App\Models\Guardian;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class Tenant2DemoSeeder extends Seeder
{
    public function run(): void
    {
        $tenantId = 2;

        // Cleanup existing demo data for tenant 2
        Child::where('tenant_id', $tenantId)->delete();
        Guardian::where('tenant_id', $tenantId)->delete();

        // Romanian name pools
        $maleFirstNames = ['Andrei','Mihai','Ion','Alexandru','Cristian','Vlad','Stefan','Ionut','Razvan','Sorin','Daniel','Florin','Radu','Bogdan','Robert','Marian','Ciprian','Gabriel','Danut','Dorian','Paul','Victor','Eduard','Lucian'];
        $femaleFirstNames = ['Elena','Ioana','Maria','Ana','Irina','Roxana','Alina','Cristina','Simona','Andreea','Mihaela','Sabina','Oana','Teodora','Larisa','Bianca','Adela','Carmen','Diana','Mara','Anca','Raluca','Alina','Denisa'];
        $lastNames = ['Popescu','Ionescu','Popa','Dumitru','Stan','Gheorghe','Tudor','Radu','Nistor','Moldovan','Stoica','Marin','Dobre','Diaconu','Nita','Gavrila','Oprea','Toma','Petrescu','Enache','Matei','Ilie','Rusu','Sandu','Barbu','Voicu','Rotaru','Neagu','Sava','Badea'];

        // Create 50 guardians (random gender), store also parsed last name
        $guardians = collect();
        for ($i = 0; $i < 50; $i++) {
            $isMale = (bool) random_int(0, 1);
            $first = $isMale ? $maleFirstNames[array_rand($maleFirstNames)] : $femaleFirstNames[array_rand($femaleFirstNames)];
            $last = $lastNames[array_rand($lastNames)];
            $name = $first.' '.$last;
            $phone = '+407'.str_pad((string)random_int(00000000, 99999999), 8, '0', STR_PAD_LEFT);
            $email = strtolower(Str::slug($first.'.'.$last.'.'.Str::random(4))).'@example.ro';

            $g = Guardian::create([
                'tenant_id' => $tenantId,
                'name' => $name,
                'phone' => $phone,
                'email' => $email,
                'notes' => null,
            ]);

            $guardians->push([
                'model' => $g,
                'last_name' => $last,
            ]);
        }

        $childrenTarget = 70;
        $andreiTarget = 20;
        $childrenCreated = 0;
        $andreiCreated = 0;

        // Guardians with 2 children (first 10)
        foreach ($guardians->take(10) as $entry) {
            $g = $entry['model'];
            $last = $entry['last_name'];
            for ($k = 0; $k < 2; $k++) {
                $first = ($andreiCreated < $andreiTarget) ? 'Andrei' : $maleFirstNames[array_rand($maleFirstNames)];
                if ($first === 'Andrei') { $andreiCreated++; }
                $internal = strtoupper(substr($first,0,2).substr($last,0,2)).random_int(100,999);
                Child::create([
                    'tenant_id' => $tenantId,
                    'guardian_id' => $g->id,
                    'first_name' => $first,
                    'last_name' => $last,
                    'birth_date' => now()->subYears(random_int(3, 12))->subDays(random_int(0, 365))->toDateString(),
                    'allergies' => null,
                    'internal_code' => $internal,
                    'notes' => null,
                ]);
                $childrenCreated++;
            }
        }

        // Guardians with 3 children (next 5)
        foreach ($guardians->slice(10, 5) as $entry) {
            $g = $entry['model'];
            $last = $entry['last_name'];
            for ($k = 0; $k < 3; $k++) {
                $pickMale = (bool) random_int(0, 1);
                $first = ($andreiCreated < $andreiTarget) ? 'Andrei' : ($pickMale ? $maleFirstNames[array_rand($maleFirstNames)] : $femaleFirstNames[array_rand($femaleFirstNames)]);
                if ($first === 'Andrei') { $andreiCreated++; }
                $internal = strtoupper(substr($first,0,2).substr($last,0,2)).random_int(100,999);
                Child::create([
                    'tenant_id' => $tenantId,
                    'guardian_id' => $g->id,
                    'first_name' => $first,
                    'last_name' => $last,
                    'birth_date' => now()->subYears(random_int(3, 12))->subDays(random_int(0, 365))->toDateString(),
                    'allergies' => null,
                    'internal_code' => $internal,
                    'notes' => null,
                ]);
                $childrenCreated++;
            }
        }

        // Fill remaining children ensuring same last name as guardian and Andrei quota
        while ($childrenCreated < $childrenTarget) {
            $entry = $guardians[random_int(0, $guardians->count() - 1)];
            $g = $entry['model'];
            $last = $entry['last_name'];
            $pickMale = (bool) random_int(0, 1);
            $first = ($andreiCreated < $andreiTarget) ? 'Andrei' : ($pickMale ? $maleFirstNames[array_rand($maleFirstNames)] : $femaleFirstNames[array_rand($femaleFirstNames)]);
            if ($first === 'Andrei') { $andreiCreated++; }
            $internal = strtoupper(substr($first,0,2).substr($last,0,2)).random_int(100,999);
            Child::create([
                'tenant_id' => $tenantId,
                'guardian_id' => $g->id,
                'first_name' => $first,
                'last_name' => $last,
                'birth_date' => now()->subYears(random_int(3, 12))->subDays(random_int(0, 365))->toDateString(),
                'allergies' => null,
                'internal_code' => $internal,
                'notes' => null,
                'is_active' => true,
            ]);
            $childrenCreated++;
        }
    }
}


