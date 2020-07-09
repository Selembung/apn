<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'role' => 'Admin',
                'name' => 'Admin Admin',
                'email' => 'admin@argon.com',
                'email_verified_at' => now(),
                'password' => Hash::make('secret'),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'role' => 'Admin',
                'name' => 'Ilham Anugrah',
                'email' => 'anugrahi96@gmail.com',
                'email_verified_at' => now(),
                'password' => Hash::make('ilhamanugrah'),
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
