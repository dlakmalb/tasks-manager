<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_task_for_their_project(): void
    {
        $user = User::factory()->create();
        $project = Project::factory()->for($user)->create();

        $response = $this->actingAs($user)->post(route('projects.tasks.store', $project), [
            'title' => 'Write tests',
            'due_date' => now()->addDays(2)->toDateString(),
        ]);

        $response->assertRedirect(route('projects.show', $project));
        $this->assertDatabaseHas('tasks', [
            'project_id' => $project->id,
            'title' => 'Write tests',
            'is_done' => false,
        ]);
    }

    public function test_user_cannot_create_task_for_other_users_project(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $otherProject = Project::factory()->for($otherUser)->create();

        $this->actingAs($user)
            ->post(route('projects.tasks.store', $otherProject), [
                'title' => 'Tamper',
            ])
            ->assertForbidden();
    }

    public function test_due_date_cannot_be_in_the_past(): void
    {
        $user = User::factory()->create();
        $project = Project::factory()->for($user)->create();

        $response = $this->actingAs($user)->post(route('projects.tasks.store', $project), [
            'title' => 'Old task',
            'due_date' => now()->subDay()->toDateString(),
        ]);

        $response->assertSessionHasErrors('due_date');
    }

    public function test_user_can_update_task_in_their_project(): void
    {
        $user = User::factory()->create();
        $project = Project::factory()->for($user)->create();
        $task = Task::factory()->for($project)->create([
            'title' => 'Old Title',
            'due_date' => now()->addDay()->toDateString(),
        ]);

        $response = $this->actingAs($user)->put(route('projects.tasks.update', [$project, $task]), [
            'title' => 'Updated Title',
            'due_date' => now()->addDays(3)->toDateString(),
        ]);

        $response->assertRedirect(route('projects.show', $project));
        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'title' => 'Updated Title',
        ]);
    }

    public function test_user_can_toggle_task_done_status(): void
    {
        $user = User::factory()->create();
        $project = Project::factory()->for($user)->create();
        $task = Task::factory()->for($project)->create(['is_done' => false]);

        $this->actingAs($user)
            ->patch(route('projects.tasks.toggle', [$project, $task]))
            ->assertRedirect(route('projects.show', $project));

        $this->assertTrue((bool) $task->fresh()->is_done);
    }

    public function test_user_can_delete_task_in_their_project(): void
    {
        $user = User::factory()->create();
        $project = Project::factory()->for($user)->create();
        $task = Task::factory()->for($project)->create();

        $response = $this->actingAs($user)->delete(route('projects.tasks.destroy', [$project, $task]));

        $response->assertRedirect(route('projects.show', $project));
        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }

    public function test_cross_project_task_tampering_returns_not_found(): void
    {
        $user = User::factory()->create();
        $projectA = Project::factory()->for($user)->create();
        $projectB = Project::factory()->for($user)->create();
        $taskInProjectB = Task::factory()->for($projectB)->create();

        $this->actingAs($user)
            ->get(route('projects.tasks.edit', [$projectA, $taskInProjectB]))
            ->assertNotFound();
    }
}
