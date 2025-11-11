<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Verifică dacă coloana username există deja
        if (!Schema::hasColumn('users', 'username')) {
            // Adaugă coloana username fără unique constraint inițial
            Schema::table('users', function (Blueprint $table) {
                $table->string('username')->nullable()->after('name');
            });
        } else {
            // Dacă există deja, elimină unique constraint-ul dacă există (pentru a putea popula valorile)
            try {
                Schema::table('users', function (Blueprint $table) {
                    $table->dropUnique(['username']);
                });
            } catch (\Exception $e) {
                // Ignoră dacă constrângerea nu există
            }
        }

        // Populează username-urile pentru utilizatorii existenți
        // Folosește email-ul sau id-ul pentru a genera username-uri unice
        $users = DB::table('users')->get();
        
        foreach ($users as $user) {
            $needsUpdate = false;
            $username = $user->username;
            
            // Dacă username-ul este gol sau null, generează unul nou
            if (empty($username)) {
                $needsUpdate = true;
                
                // Încearcă să genereze username din email
                if (!empty($user->email)) {
                    $emailParts = explode('@', $user->email);
                    $username = $emailParts[0];
                    
                    // Curăță username-ul de caractere invalide
                    $username = preg_replace('/[^a-zA-Z0-9_]/', '_', $username);
                } else {
                    // Dacă nu are email, folosește 'user_' + id
                    $username = 'user_' . $user->id;
                }
            }
            
            // Verifică dacă username-ul există deja pentru alt utilizator
            $exists = DB::table('users')
                ->where('username', $username)
                ->where('id', '!=', $user->id)
                ->exists();
            
            // Dacă există, adaugă id-ul la sfârșit
            if ($exists) {
                $username = $username . '_' . $user->id;
                $needsUpdate = true;
            }
            
            // Actualizează username-ul dacă este necesar
            if ($needsUpdate || $user->username !== $username) {
                DB::table('users')
                    ->where('id', $user->id)
                    ->update(['username' => $username]);
            }
        }

        // Verifică dacă unique constraint-ul există deja
        $indexes = DB::select("SHOW INDEXES FROM users WHERE Key_name = 'users_username_unique'");
        
        if (empty($indexes)) {
            // Acum adaugă unique constraint-ul
            Schema::table('users', function (Blueprint $table) {
                $table->string('username')->nullable(false)->change();
                $table->unique('username');
            });
        } else {
            // Dacă există deja, doar asigură-te că nu este nullable
            Schema::table('users', function (Blueprint $table) {
                $table->string('username')->nullable(false)->change();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique(['username']);
            $table->dropColumn('username');
        });
    }
};
