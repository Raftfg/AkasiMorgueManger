<?php

namespace Modules\Comptabilite\Database\Seeders;

use Modules\Comptabilite\Entities\Journal;
use Illuminate\Database\Seeder;

class JournalSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        Journal::create([
            'id' => 1,
            'code' => 'JNL01',
            'libelle' => 'Journal des factures de la pharmacie',
            'description' => 'Les factures relatives aux achats de médicaments à la pharmacie',
            'compte_debit_id' => 1064,
            // 'compte_credit_id' => NULL,
            'user_id' => 1,
        ]);

        Journal::create([
            'id' => 2,
            'code' => 'JNL02',
            'libelle' => 'Journal des factures des prestations',
            'description' => 'Les factures relatives aux différentes prestations fournies pas le centre',
            'compte_debit_id' => 1064,
            // 'compte_credit_id' => NULL,
            'user_id' => 1,
        ]);

    }

}
