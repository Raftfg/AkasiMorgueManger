<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {

    /**
     * Seed the application's database.
     */
    public function run(): void {
        /*
          |--------------------------------------------------------------------------
          | ACL
          |--------------------------------------------------------------------------
         */
        $this->call(\Modules\Acl\Database\Seeders\RolesAndPermissionsSeeder::class);
        $this->command->info('RolesAndPermissions table seeded !');
        $this->call(\Modules\Acl\Database\Seeders\UserSeeder::class);
        $this->command->info('User table seeded !');
        $this->call(\Modules\Comptabilite\Database\Seeders\SAccountClassesSeeder::class);
        $this->command->info('SAccountClasses table seeded !');
        $this->call(\Modules\Comptabilite\Database\Seeders\SAccountsSeeder::class);
        $this->command->info('SAccounts table seeded !');
        $this->call(\Modules\Comptabilite\Database\Seeders\ExerciceSeeder::class);
        $this->command->info('Exercices table seeded !');
        $this->call(\Modules\Comptabilite\Database\Seeders\DeviseSeeder::class);
        $this->command->info('Devises table seeded !');
        $this->call(\Modules\Comptabilite\Database\Seeders\JournalSeeder::class);
        $this->command->info('Journaux table seeded !');
        $this->call(\Modules\Comptabilite\Database\Seeders\ParametreSeeder::class);
        $this->command->info('Paramètres table seeded !');

        /*
          |---------------------------------
          | ABSENCE
          |--------------------------------
         */
        // $this->call(\Modules\Comptabilite\Database\Seeders\TypeVacationSeeder::class);
        // $this->command->info('TypeVacation table seeded !');

        /*
          |---------------------------------
          | SEPARATION
          |--------------------------------
         */
        // $this->call(\Modules\Separation\Database\Seeders\PieceSeeder::class);
        // $this->command->info('Piece table seeded !');
    }

}
