<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users = [
            User::factory()->create([
                'name' => 'User A',
                'email' => 'usera@example.com',
                'password' => Hash::make('password'),
            ]),
            User::factory()->create([
                'name' => 'User B',
                'email' => 'userb@example.com',
                'password' => Hash::make('password'),
            ]),
        ];

        foreach ($users as $user) {
            Project::factory()
                ->count(2)
                ->for($user)
                ->create()
                ->each(function (Project $project): void {
                    Task::factory()
                        ->count(5)
                        ->for($project)
                        ->state(new \Illuminate\Database\Eloquent\Factories\Sequence(
                            ['is_done' => false],
                            ['is_done' => true],
                            ['is_done' => false],
                            ['is_done' => true],
                            ['is_done' => false],
                        ))
                        ->create();
                });
        }
    }
}
