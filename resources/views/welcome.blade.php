<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Tasks Manager') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-50 text-slate-900">
    <div class="mx-auto flex min-h-screen max-w-6xl flex-col px-4 py-8 sm:px-6 lg:px-8">
        <header class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-slate-900 text-sm font-bold text-white">TM</div>
                <div>
                    <p class="text-sm font-semibold tracking-wide">Tasks Manager</p>
                    <p class="text-xs text-slate-500">Plan projects. Track tasks. Stay organized.</p>
                </div>
            </div>

            @if (Route::has('login'))
                <nav class="flex items-center gap-2">
                    @auth
                        <a href="{{ route('projects.index') }}"
                           class="rounded-lg bg-slate-900 px-4 py-2 text-sm font-medium text-white hover:bg-slate-800">
                            Open App
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                           class="rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100">
                            Log In
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                               class="rounded-lg bg-slate-900 px-4 py-2 text-sm font-medium text-white hover:bg-slate-800">
                                Register
                            </a>
                        @endif
                    @endauth
                </nav>
            @endif
        </header>

        <main class="my-auto py-10">
            <div class="grid gap-8 lg:grid-cols-2 lg:gap-10">
                <section>
                    <p class="mb-3 inline-flex items-center rounded-full border border-blue-200 bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-700">
                        Server-rendered Laravel + Blade
                    </p>
                    <h1 class="text-4xl font-bold leading-tight sm:text-5xl">
                        Manage projects and tasks with clean ownership rules.
                    </h1>
                    <p class="mt-4 max-w-xl text-base text-slate-600">
                        A focused productivity app where each user can create projects, track tasks, and manage progress with proper authorization and validation.
                    </p>

                    <div class="mt-7 flex flex-wrap gap-3">
                        @auth
                            <a href="{{ route('projects.index') }}"
                               class="rounded-lg bg-slate-900 px-5 py-2.5 text-sm font-semibold text-white hover:bg-slate-800">
                                Go to Projects
                            </a>
                        @else
                            <a href="{{ route('register') }}"
                               class="rounded-lg bg-slate-900 px-5 py-2.5 text-sm font-semibold text-white hover:bg-slate-800">
                                Get Started
                            </a>
                        @endauth
                    </div>
                </section>

                <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h2 class="text-lg font-semibold">What this app includes</h2>
                    <ul class="mt-4 space-y-3 text-sm text-slate-600">
                        <li class="rounded-lg border border-slate-200 bg-slate-50 px-3 py-2">
                            Authentication with login/register/logout.
                        </li>
                        <li class="rounded-lg border border-slate-200 bg-slate-50 px-3 py-2">
                            Project CRUD with task count and pagination.
                        </li>
                        <li class="rounded-lg border border-slate-200 bg-slate-50 px-3 py-2">
                            Nested task management: create, edit, delete, done/undo.
                        </li>
                        <li class="rounded-lg border border-slate-200 bg-slate-50 px-3 py-2">
                            Ownership-based authorization and request validation.
                        </li>
                    </ul>
                </section>
            </div>
        </main>
    </div>
</body>
</html>
