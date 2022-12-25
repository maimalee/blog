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
        User::query()->create([
            'name' => 'Anas Maimalee',
            'email' => 'anas@blog.test',
            'role' => 'user',
            'password' => Hash::make(1234),
        ]);
        User::query()->create([
            'name' => 'Ahmard Kwaro',
            'email' => 'ahmard@blog.test',
            'role' => 'user',
            'password' => Hash::make(1234),
        ]);
        User::query()->create([
            'name' => 'Yakubi Kwaro',
            'email' => 'ykb@blog.test',
            'role' => 'user',
            'password' => Hash::make(1234),
        ]);
        User::query()->create([
            'name' => 'Anas',
            'email' => 'anas@admin.test',
            'role' => 'admin',
            'password' => Hash::make(1234),
        ]);
        User::Factory(mt_rand(10,15))->create();

    }
}
