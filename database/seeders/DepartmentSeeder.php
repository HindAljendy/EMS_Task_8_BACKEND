<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Department::create([
            'name'        => 'flutter',
            'description' => 'responsible for design web applications'
        ]);

        Department::create([
            'name'       => 'fullStack',
            'description' => 'responsible for frontend and backend sections'
        ]);
    }
}
