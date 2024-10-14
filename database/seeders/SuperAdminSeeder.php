<?php

namespace Database\Seeders;

use App\Models\SuperAdmin;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superadmin = SuperAdmin::create([
            'name' => 'My Rapido',
            'email' => 'superadmin@myrapido.pk',
            'password' => bcrypt('superadmin123'), // Choose a secure password
        ]);

    }
}
