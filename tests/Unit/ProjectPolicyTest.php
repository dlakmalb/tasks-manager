<?php

namespace Tests\Unit;

use App\Models\Project;
use App\Models\User;
use App\Policies\ProjectPolicy;
use PHPUnit\Framework\TestCase;

class ProjectPolicyTest extends TestCase
{
    public function test_owner_can_view_update_and_delete_project(): void
    {
        $user = new User;
        $user->id = 10;

        $project = new Project;
        $project->user_id = 10;

        $policy = new ProjectPolicy;

        $this->assertTrue($policy->view($user, $project));
        $this->assertTrue($policy->update($user, $project));
        $this->assertTrue($policy->delete($user, $project));
    }

    public function test_non_owner_cannot_view_update_or_delete_project(): void
    {
        $user = new User;
        $user->id = 10;

        $project = new Project;
        $project->user_id = 99;

        $policy = new ProjectPolicy;

        $this->assertFalse($policy->view($user, $project));
        $this->assertFalse($policy->update($user, $project));
        $this->assertFalse($policy->delete($user, $project));
    }
}
