<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::Create([
           'name' => 'Elmenofy',
           'email' => 'Elmenofy@a.com',
           'password' => bcrypt('123123123'),
        ]);
    }
}
