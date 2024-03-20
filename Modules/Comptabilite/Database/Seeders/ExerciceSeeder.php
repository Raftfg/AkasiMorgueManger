<?php

namespace Modules\Comptabilite\Database\Seeders;

use Modules\Comptabilite\Entities\Exercice;
use Illuminate\Database\Seeder;

class ExerciceSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        Exercice::create([
            'id' => 1,
            'code' => 'EXC01',
            'libelle' => 'Exercice 2022',
            'description' => 'Exercice de l\'année 2022',
            'date_debut' => '2022/01/01',
            'date_fin' => '2022/12/31',
            'user_id' => 1,
        ]);

        Exercice::create([
            'id' => 2,
            'code' => 'EXC02',
            'libelle' => 'Exercice 2023',
            'description' => 'Exercice de l\'année 2023',
            'date_debut' => '2023/01/01',
            'date_fin' => '2023/12/31',
            'user_id' => 1,
        ]);

        Exercice::create([
            'id' => 3,
            'code' => 'EXC03',
            'libelle' => 'Exercice 2024',
            'description' => 'Exercice de l\'année 2024',
            'date_debut' => '2024/01/01',
            'date_fin' => '2024/12/31',
            'user_id' => 1,
        ]);

    }

}
