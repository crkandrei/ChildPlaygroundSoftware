<?php

namespace App\Console\Commands;

use App\Models\Child;
use Illuminate\Console\Command;

class MigrateChildNamesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'children:migrate-names';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrează numele copiilor: concatenează first_name + last_name în first_name';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('═══════════════════════════════════════════════════════');
        $this->info('  Migrare Nume Copii');
        $this->info('═══════════════════════════════════════════════════════');
        $this->newLine();

        // Obține toți copiii
        $children = Child::all();
        $total = $children->count();

        if ($total === 0) {
            $this->warn('Nu există copii în baza de date.');
            return Command::SUCCESS;
        }

        $this->info("Total copii de procesat: {$total}");
        $this->newLine();

        $updated = 0;
        $skipped = 0;
        $bar = $this->output->createProgressBar($total);
        $bar->start();

        foreach ($children as $child) {
            if ($child->last_name !== null && trim($child->last_name) !== '') {
                // Concatenează first_name + ' ' + last_name în first_name
                $fullName = trim($child->first_name . ' ' . $child->last_name);
                $child->first_name = $fullName;
                $child->save();
                $updated++;
            } else {
                // Lasă first_name neschimbat pentru copiii cu last_name NULL sau gol
                $skipped++;
            }
            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);

        // Afișează statistici
        $this->info('═══════════════════════════════════════════════════════');
        $this->info('  Rezumat');
        $this->info('═══════════════════════════════════════════════════════');
        $this->table(
            ['Statistică', 'Valoare'],
            [
                ['Total copii', $total],
                ['Actualizați (cu last_name)', $updated],
                ['Lăsați neschimbați (fără last_name)', $skipped],
            ]
        );

        $this->newLine();
        $this->info('✅ Migrarea numelor a fost finalizată cu succes!');
        $this->warn('⚠️  Următorul pas: rulează migrația pentru redenumire first_name → name și ștergere last_name');

        return Command::SUCCESS;
    }
}

