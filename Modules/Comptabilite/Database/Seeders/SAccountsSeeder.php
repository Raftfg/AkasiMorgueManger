<?php

namespace Modules\Comptabilite\Database\Seeders;

use Exception;
use Illuminate\Database\Seeder;
use Modules\Comptabilite\Entities\Saccount;

class SAccountsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $filepath='Modules/Comptabilite/Database/Seeders/data/syscohada_accounts.json';

        if (file_exists($filepath)) {
            $syscohada_accounts = json_decode(file_get_contents(base_path($filepath)));
            \Illuminate\Support\Facades\DB::beginTransaction();
            try {
                foreach ($syscohada_accounts as $account) {
                    Saccount::create((array)$account);
                }
                \Illuminate\Support\Facades\DB::commit();
            } catch (Exception $e) {
                \Illuminate\Support\Facades\DB::rollBack();
            }

        };
    }
}