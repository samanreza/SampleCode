<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class Task extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Task::factory()
            ->count(10)
            ->create();
    }
}
