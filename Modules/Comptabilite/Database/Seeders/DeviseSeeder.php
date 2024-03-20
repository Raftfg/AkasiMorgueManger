<?php

namespace Modules\Comptabilite\Database\Seeders;

use Modules\Comptabilite\Entities\Devise;
use Illuminate\Database\Seeder;

class DeviseSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        Devise::create([
            'id' => 1,
            'code' => 'DEV01',
            'libelle' => 'FCFA',
            'description' => 'Franc des Colonies Françaises d\'Afrique',
            'user_id' => 1,
        ]);

        Devise::create([
            'id' => 2,
            'code' => 'DEV02',
            'libelle' => 'Naïra',
            'description' => 'Naïra',
            'user_id' => 1,
        ]);

        Devise::create([
            'id' => 3,
            'code' => 'DEV03',
            'libelle' => 'Dollar',
            'description' => 'Dollar Américain',
            'user_id' => 1,
        ]);

        Devise::create([
            'id' => 4,
            'code' => 'DEV04',
            'libelle' => 'Euro',
            'description' => 'Euro',
            'user_id' => 1,
        ]);

    }

}
