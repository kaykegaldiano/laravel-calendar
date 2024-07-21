<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Calendars') }}
            </h2>
            <a href="{{ route('calendars.create') }}" class="btn btn-outline btn-success">{{ __('Create Calendar') }}</a>
        </div>
    </x-slot>

    <div class="py-12">

        @session('success')
            <div role="alert" class="alert alert-success mb-4 max-w-7xl mx-auto sm:px-6 lg:px-8">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-6 w-6 shrink-0 stroke-current"
                    fill="none"
                    viewBox="0 0 24 24">
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ $value }}</span>
            </div>
        @endsession

        <div class="mx-auto max-w-7xl gap-x-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="overflow-x-auto">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>{{ __('Title') }}</th>
                                    <th>{{ __('Description') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Published At') }}</th>
                                    <th>{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($calendars as $calendar)
                                    <tr>
                                        <td>{{ $calendar->title }}</td>
                                        <td>{{ $calendar->description }}</td>
                                        <td>{{ $calendar->status->getName() }}</td>
                                        <td>{{ $calendar->published_at }}</td>
                                        <td>
                                            <div class="flex items-center gap-x-2">
                                                <a href="{{ route('calendars.edit', $calendar) }}" class="btn btn-outline btn-info">{{ __('Edit') }}</a>
                                                <form action="{{ route('calendars.destroy', $calendar) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button
                                                        type="submit"
                                                        class="btn btn-outline btn-error"
                                                        onclick="return confirm('{{ __('Are you sure you want to delete this calendar?') }}')"
                                                    >
                                                        {{ __('Delete') }}
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
