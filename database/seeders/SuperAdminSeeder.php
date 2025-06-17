<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'superadmin@contoshop.fr'],
            [
                'nom' => 'Super Admin',
                'mot_de_passe' => Hash::make('Admin@123'),
                'role_id' => 1
            ]
        );
    }
}
