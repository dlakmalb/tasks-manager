<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $project->name }}</h2>
                <p class="text-sm text-gray-500 mt-1">Tasks inside this project.</p>
            </div>

            <a href="{{ route('projects.index') }}"
               class="inline-flex items-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
                Back to Projects
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-3 rounded-lg bg-green-50 border border-green-200 px-4 py-2 text-green-800">
                    {{ session('success') }}
                </div>
            @endif

            <div class="mb-4 bg-white shadow-sm rounded-lg overflow-hidden border border-gray-200">
                <div class="border-b border-gray-200 px-6 py-4">
                    <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wide">Add Task</h3>
                </div>

                <form method="POST" action="{{ route('projects.tasks.store', $project) }}" class="p-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="md:col-span-2">
                            <x-input-label for="title">
                                {{ __('Task Title') }} <span class="text-red-600">*</span>
                            </x-input-label>
                            <x-text-input
                                id="title"
                                name="title"
                                type="text"
                                class="mt-1 block w-full"
                                :value="old('title')"
                                required
                            />
                            <x-input-error class="mt-2" :messages="$errors->get('title')" />
                        </div>

                        <div>
                            <x-input-label for="due_date" :value="__('Due Date')" />
                            <x-text-input
                                id="due_date"
                                name="due_date"
                                type="date"
                                class="mt-1 block w-full"
                                :value="old('due_date')"
                                min="{{ now()->toDateString() }}"
                            />
                            <x-input-error class="mt-2" :messages="$errors->get('due_date')" />
                        </div>
                    </div>

                    <div class="mt-4">
                        <x-primary-button>{{ __('Add Task') }}</x-primary-button>
                    </div>
                </form>
            </div>

            <div class="bg-white shadow-sm rounded-lg overflow-hidden border border-gray-200">
                <div class="border-b border-gray-200 px-6 py-4 flex items-center justify-between">
                    <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wide">Task List</h3>
                    <span class="inline-flex items-center rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-medium text-gray-700">
                        {{ $project->tasks->count() }} total
                    </span>
                </div>

                @if ($project->tasks->isEmpty())
                    <div class="p-7 text-gray-600">
                        No tasks added yet for this project.
                    </div>
                @else
                    <div class="max-h-[28rem] overflow-y-auto overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="sticky top-0 bg-gray-50 px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Title</th>
                                    <th class="sticky top-0 bg-gray-50 px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                                    <th class="sticky top-0 bg-gray-50 px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Due Date</th>
                                    <th class="sticky top-0 bg-gray-50 px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($project->tasks as $task)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 text-sm text-gray-900">
                                            {{ $task->title }}
                                        </td>
                                        <td class="px-6 py-4">
                                            @if ($task->is_done)
                                                <span class="inline-flex items-center rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800">
                                                    Done
                                                </span>
                                            @else
                                                <span class="inline-flex items-center rounded-full bg-yellow-100 px-2.5 py-0.5 text-xs font-medium text-yellow-800">
                                                    To Do
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-700">
                                            {{ $task->due_date?->format('M d, Y') ?? 'No due date' }}
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <div class="inline-flex items-center gap-2">
                                                <form method="POST" action="{{ route('projects.tasks.toggle', [$project, $task]) }}">
                                                    @csrf
                                                    @method('PATCH')
                                                    @if ($task->is_done)
                                                        <button type="submit"
                                                                class="inline-flex items-center rounded-md border border-yellow-300 bg-white px-3 py-1.5 text-xs font-medium text-yellow-700 hover:bg-yellow-50">
                                                            Undo
                                                        </button>
                                                    @else
                                                        <button type="submit"
                                                                class="inline-flex items-center rounded-md border border-green-300 bg-white px-3 py-1.5 text-xs font-medium text-green-700 hover:bg-green-50">
                                                            Mark Done
                                                        </button>
                                                    @endif
                                                </form>
                                                <a href="{{ route('projects.tasks.edit', [$project, $task]) }}"
                                                   class="inline-flex items-center rounded-md border border-gray-300 bg-white px-3 py-1.5 text-xs font-medium text-gray-700 hover:bg-gray-50">
                                                    Edit
                                                </a>
                                                <form method="POST"
                                                      action="{{ route('projects.tasks.destroy', [$project, $task]) }}"
                                                      onsubmit="return confirm('Delete this task?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="inline-flex items-center rounded-md border border-red-300 bg-white px-3 py-1.5 text-xs font-medium text-red-700 hover:bg-red-50">
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
