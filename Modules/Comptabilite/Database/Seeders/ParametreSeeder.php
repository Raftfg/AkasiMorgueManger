<?php

namespace Modules\Comptabilite\Database\Seeders;

use Modules\Comptabilite\Entities\Parametre;
use Illuminate\Database\Seeder;

class ParametreSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        Parametre::create([
            'exercice_id' => 2,
            'devise_id' => 1,
            'user_id' => 1,
        ]);
    }

}
