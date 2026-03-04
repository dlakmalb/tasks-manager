<x-app-layout>
    @php($displayTimezone = 'Asia/Colombo')

    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Projects</h2>
                <p class="text-sm text-gray-500 mt-1">Manage your projects and tasks in one place.</p>
            </div>

            <a href="{{ route('projects.create') }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-gray-900 text-white rounded-lg text-sm hover:bg-gray-800">
                <span class="text-lg leading-none">+</span>
                Create Project
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

            {{-- Card wrapper (Bootstrap-like) --}}
            @if ($projects->isEmpty())
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        {{ __("No projects available. Create a new project to get started.") }}
                    </div>
                </div>
            @else
                <div class="bg-white shadow-sm rounded-lg overflow-hidden border border-gray-200">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Project
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Tasks
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Created Date
                                </th>
                                <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                            </thead>

                            <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($projects as $project)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4">
                                        <a href="{{ route('projects.show', $project) }}"
                                           class="font-medium text-gray-900 hover:text-blue-700 hover:underline">
                                            {{ $project->name }}
                                        </a>
                                    </td>

                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700">
                                            {{ $project->tasks_count }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-4 text-sm text-gray-700">
                                        <span title="{{ $project->created_at->timezone($displayTimezone)->format('M d, Y h:i A') }}">
                                            {{ $project->created_at->timezone($displayTimezone)->diffForHumans() }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-4 text-right">
                                        <div class="inline-flex items-center gap-3">
                                            <a href="{{ route('projects.show', $project) }}"
                                               class="inline-flex items-center rounded-md border border-blue-300 bg-white px-3 py-1.5 text-xs font-medium text-blue-700 hover:bg-blue-50">
                                                View
                                            </a>
                                            <a href="{{ route('projects.edit', $project) }}"
                                               class="inline-flex items-center rounded-md border border-gray-300 bg-white px-3 py-1.5 text-xs font-medium text-gray-700 hover:bg-gray-50">
                                                Edit
                                            </a>
                                            <form method="POST" action="{{ route('projects.destroy', $project) }}"
                                                  onsubmit="return confirm('Delete this project and all its tasks?')">
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

                    @if ($projects->hasPages())
                        <div class="border-t border-gray-200 px-4 py-3 sm:px-6">
                            {{ $projects->onEachSide(1)->links() }}
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
