<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       User::create([
           'name' => 'Osid alkourd' ,
           'email' => 'alkordosid73@gmail.com' ,
           'password' => Hash::make('osidosid') ,
           'phone_number' => '0599608424' ,
       ]);
    }
}
