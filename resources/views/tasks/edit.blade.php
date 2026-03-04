<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Task</h2>
                <p class="text-sm text-gray-500 mt-1">{{ $project->name }}</p>
            </div>

            <a href="{{ route('projects.show', $project) }}"
               class="inline-flex items-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
                Back to Project
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg overflow-hidden border border-gray-200">
                <form method="POST" action="{{ route('projects.tasks.update', [$project, $task]) }}" class="p-6 space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <x-input-label for="title">
                            {{ __('Task Title') }} <span class="text-red-600">*</span>
                        </x-input-label>
                        <x-text-input
                            id="title"
                            name="title"
                            type="text"
                            class="mt-1 block w-full"
                            :value="old('title', $task->title)"
                            required
                            autofocus
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
                            :value="old('due_date', optional($task->due_date)->format('Y-m-d'))"
                            min="{{ now()->toDateString() }}"
                        />
                        <x-input-error class="mt-2" :messages="$errors->get('due_date')" />
                    </div>

                    <div class="flex items-center gap-3">
                        <x-primary-button>{{ __('Update Task') }}</x-primary-button>
                        <a href="{{ route('projects.show', $project) }}" class="text-sm text-gray-600 hover:text-gray-900">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
