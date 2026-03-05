<?php

namespace Tests\Unit;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class TaskModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_casts_is_done_to_boolean(): void
    {
        $user = User::factory()->create();
        $project = Project::factory()->for($user)->create();
        $task = Task::factory()->for($project)->create(['is_done' => 1]);

        $this->assertIsBool($task->is_done);
        $this->assertTrue($task->is_done);
    }

    public function test_it_casts_due_date_to_carbon_date(): void
    {
        $user = User::factory()->create();
        $project = Project::factory()->for($user)->create();
        $task = Task::factory()->for($project)->create(['due_date' => '2026-03-10']);

        $this->assertInstanceOf(Carbon::class, $task->due_date);
        $this->assertSame('2026-03-10', $task->due_date->format('Y-m-d'));
    }
}
