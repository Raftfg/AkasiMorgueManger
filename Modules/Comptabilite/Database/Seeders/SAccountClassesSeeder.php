<?php

namespace Modules\Comptabilite\Database\Seeders;

use Exception;
use Illuminate\Database\Seeder;
use Modules\Comptabilite\Entities\SaccountClass;

class SAccountClassesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $filepath='Modules/Comptabilite/Database/Seeders/data/syscohada_account_classes.json';

        if(file_exists($filepath)){
            $ohada_classes = json_decode(file_get_contents(base_path($filepath)));
            \Illuminate\Support\Facades\DB::beginTransaction();
            try{
                foreach ($ohada_classes as $classe) {
                    SaccountClass::create((array)$classe);
                }

                \Illuminate\Support\Facades\DB::commit();
            }catch (Exception $e){
                \Illuminate\Support\Facades\DB::rollBack();
            }


        };
    }
}