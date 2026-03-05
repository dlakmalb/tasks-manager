<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_projects_pages(): void
    {
        $this->get(route('projects.index'))->assertRedirect(route('login'));
        $this->get(route('projects.create'))->assertRedirect(route('login'));
    }

    public function test_user_only_sees_their_own_projects_on_index(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();

        $ownProject = Project::factory()->for($user)->create(['name' => 'My Project']);
        Project::factory()->for($otherUser)->create(['name' => 'Other Project']);

        $response = $this->actingAs($user)->get(route('projects.index'));

        $response->assertOk();
        $response->assertSee($ownProject->name);
        $response->assertDontSee('Other Project');
    }

    public function test_user_can_create_project(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('projects.store'), [
            'name' => 'New Project',
        ]);

        $response->assertRedirect(route('projects.index'));
        $this->assertDatabaseHas('projects', [
            'user_id' => $user->id,
            'name' => 'New Project',
        ]);
    }

    public function test_project_name_is_required_when_creating_project(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('projects.store'), [
            'name' => '',
        ]);

        $response->assertSessionHasErrors('name');
    }

    public function test_user_cannot_view_another_users_project(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $otherProject = Project::factory()->for($otherUser)->create();

        $this->actingAs($user)
            ->get(route('projects.show', $otherProject))
            ->assertForbidden();
    }

    public function test_user_cannot_update_another_users_project(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $otherProject = Project::factory()->for($otherUser)->create(['name' => 'Original']);

        $this->actingAs($user)
            ->put(route('projects.update', $otherProject), [
                'name' => 'Hacked',
            ])
            ->assertForbidden();

        $this->assertDatabaseHas('projects', [
            'id' => $otherProject->id,
            'name' => 'Original',
        ]);
    }

    public function test_user_can_delete_their_own_project(): void
    {
        $user = User::factory()->create();
        $project = Project::factory()->for($user)->create();

        $response = $this->actingAs($user)->delete(route('projects.destroy', $project));

        $response->assertRedirect(route('projects.index'));
        $this->assertDatabaseMissing('projects', ['id' => $project->id]);
    }
}
