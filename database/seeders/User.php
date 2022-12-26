<?php

namespace Database\Seeders;

use App\Models\User as UserModel;
use \App\Models\Task as TaskModel;
use Database\Factories\UserFactory;
use Illuminate\Database\Seeder;

class User extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*\App\Models\User::query()->create([
            'username' => 'sami',
            'password' => bcrypt('123456'),
            'role' => 'member'
        ]);

        \App\Models\User::query()->create([
            'username' => 'saman',
            'password' => bcrypt('123456'),
            'role' => 'admin'
        ]);*/

//        \App\Models\User::factory()
//        ->count(10)
//        ->create();

        UserModel::factory()
            ->count(10)
            ->hasAttached(TaskModel::factory()->count(3))
            ->create();
    }
}
