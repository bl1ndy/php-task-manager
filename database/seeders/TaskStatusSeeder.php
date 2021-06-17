<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\TaskStatus;

class TaskStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TaskStatus::create(['name' => 'Новый']);
        TaskStatus::create(['name' => 'В работе']);
        TaskStatus::create(['name' => 'На тестировании']);
        TaskStatus::create(['name' => 'Завершен']);
    }
}
