<?php

namespace Modules\Acl\Database\Seeders;

use Modules\Acl\Entities\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        $user = User::create([
            'id' => 1,
            'firstname' => 'System',
            'lastname' => 'System',
            'email' => 'system@system.com',
            'password' => Hash::make('System@!'),
            'email_verified_at' => now()->toDateTimeString(),
        ]);

            $user = User::create([
            'id' => 2,
            'firstname' => 'Super',
            'lastname' => 'Formation',
            'email' => 'super@formation.com',
            'password' => Hash::make('MotDeP@sse!'),
            'email_verified_at' => now()->toDateTimeString(),
        ]);
        $user->assignRole('Super');

        $user = User::create([
            'id' => 3,
            'firstname' => 'Admin',
            'lastname' => 'Formation',
            'email' => 'admin@formation.com',
            'password' => Hash::make('MotDeP@sse!'),
            'email_verified_at' => now()->toDateTimeString(),
        ]);
        $user->assignRole('Admin');        

        $user = User::create([
            'id' => 4,
            'firstname' => 'KPOTIN',
            'lastname' => 'Emmanuel',
            'email' => 'ekpotin@gmail.com',
            'password' => Hash::make('MotDeP@sse!'),
            'email_verified_at' => now()->toDateTimeString(),
        ]);
        $user->assignRole('Agent');
        $user->assignRole('Super'); 
        
    }

}
