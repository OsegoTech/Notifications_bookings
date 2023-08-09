<?php

namespace Database\Seeders;

use App\Models\ClassType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use PhpParser\Builder\Class_;

class ClassTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ClassType::create([
            'name' => 'Yoga',
            'desdcription' => fake()->text(),
            'minutes' => 60
        ]);
        ClassType::create([
            'name' => 'Dance Fitness',
            'desdcription' => fake()->text(),
            'minutes' => 45
        ]);
        ClassType::create([
            'name' => 'Pilates',
            'desdcription' => fake()->text(),
            'minutes' => 60
        ]);
        ClassType::create([
            'name' => 'Boxing',
            'desdcription' => fake()->text(),
            'minutes' => 50
        ]);
        ClassType::create([
            'name' => 'kungfu',
            'desdcription' => fake()->text(),
            'minutes' => 100
        ]);
        
    }
}
