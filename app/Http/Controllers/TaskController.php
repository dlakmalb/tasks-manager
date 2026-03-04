<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TaskController extends Controller
{
    /**
     * Store a newly created task in the given project.
     */
    public function store(StoreTaskRequest $request, Project $project): RedirectResponse
    {
        $project->tasks()->create($request->validated());

        return redirect()
            ->route('projects.show', $project)
            ->with('success', 'Task created successfully.');
    }

    /**
     * Show the form for editing the specified task.
     */
    public function edit(Project $project, Task $task): View
    {
        $this->authorize('update', $project);
        $task = $project->tasks()->findOrFail($task->id);

        return view('tasks.edit', compact('project', 'task'));
    }

    /**
     * Toggle done/undone status for the specified task.
     */
    public function toggleStatus(Project $project, Task $task): RedirectResponse
    {
        $this->authorize('update', $project);
        $task = $project->tasks()->findOrFail($task->id);

        $task->update([
            'is_done' => ! $task->is_done,
        ]);

        return redirect()
            ->route('projects.show', $project)
            ->with('success', $task->is_done ? 'Task marked as done.' : 'Task marked as to do.');
    }

    /**
     * Update the specified task in storage.
     */
    public function update(UpdateTaskRequest $request, Project $project, Task $task): RedirectResponse
    {
        $task = $project->tasks()->findOrFail($task->id);
        $task->update($request->validated());

        return redirect()
            ->route('projects.show', $project)
            ->with('success', 'Task updated successfully.');
    }

    /**
     * Remove the specified task from storage.
     */
    public function destroy(Project $project, Task $task): RedirectResponse
    {
        $this->authorize('update', $project);
        $task = $project->tasks()->findOrFail($task->id);
        $task->delete();

        return redirect()
            ->route('projects.show', $project)
            ->with('success', 'Task deleted successfully.');
    }
}
