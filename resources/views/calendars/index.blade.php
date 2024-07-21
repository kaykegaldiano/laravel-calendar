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

        <div class="flex justify-between gap-x-4 sm:px-6 lg:px-8">
            <div class="basis-[70%]">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        {{--                    <div class="overflow-x-auto">--}}
                        {{--                        <table class="table">--}}
                        {{--                            <thead>--}}
                        {{--                                <tr>--}}
                        {{--                                    <th>{{ __('Title') }}</th>--}}
                        {{--                                    <th>{{ __('Description') }}</th>--}}
                        {{--                                    <th>{{ __('Status') }}</th>--}}
                        {{--                                    <th>{{ __('Published At') }}</th>--}}
                        {{--                                    <th>{{ __('Actions') }}</th>--}}
                        {{--                                </tr>--}}
                        {{--                            </thead>--}}
                        {{--                            <tbody>--}}
                        {{--                                @foreach ($calendars as $calendar)--}}
                        {{--                                    <tr>--}}
                        {{--                                        <td>{{ $calendar->title }}</td>--}}
                        {{--                                        <td>{{ $calendar->description }}</td>--}}
                        {{--                                        <td>{{ $calendar->status }}</td>--}}
                        {{--                                        <td>{{ $calendar->published_at }}</td>--}}
                        {{--                                        <td>--}}
                        {{--                                            <div class="flex items-center gap-x-2">--}}
                        {{--                                                <a href="{{ route('calendars.edit', $calendar) }}" class="btn btn-outline btn-info">{{ __('Edit') }}</a>--}}
                        {{--                                                <form action="{{ route('calendars.destroy', $calendar) }}" method="POST">--}}
                        {{--                                                    @csrf--}}
                        {{--                                                    @method('DELETE')--}}
                        {{--                                                    <button--}}
                        {{--                                                        type="submit"--}}
                        {{--                                                        class="btn btn-outline btn-error"--}}
                        {{--                                                        onclick="return confirm('{{ __('Are you sure you want to delete this calendar?') }}')"--}}
                        {{--                                                    >--}}
                        {{--                                                        {{ __('Delete') }}--}}
                        {{--                                                    </button>--}}
                        {{--                                                </form>--}}
                        {{--                                            </div>--}}
                        {{--                                        </td>--}}
                        {{--                                    </tr>--}}
                        {{--                                @endforeach--}}
                        {{--                            </tbody>--}}
                        {{--                        </table>--}}
                        {{--                    </div>--}}
                        <div id="calendar"></div>
                    </div>
                </div>
            </div>
            <div class="basis-auto" id="events">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <div class="flex flex-col gap-2">
                            @foreach($notPublishedCalendars as $calendar)
                                <div class="calendar-event bg-gray-200 dark:bg-gray-600 overflow-hidden shadow-sm sm:rounded-lg" data-route="{{ route('calendars.update', $calendar->id) }}">
                                    <div class="p-6 text-gray-700 dark:text-gray-200">
                                        <p>{{ $calendar->title }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('script')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const eventsEl = document.getElementById('events');
                const calendarEl = document.getElementById('calendar');

                new Draggable(eventsEl, {
                    itemSelector: '.calendar-event',
                    eventData: function (eventEl) {
                        return {
                            title: eventEl.innerText
                        }
                    }
                });

                const calendar = new Calendar(calendarEl, {
                    plugins: [dayGridPlugin, interactionPlugin],
                    initialView: 'dayGridMonth',
                    height: 'auto',
                    droppable: true,
                    editable: true,
                    headerToolbar: {
                        left: 'title',
                        center: '',
                        right: 'prev,next',
                    },
                    events: '{{ route('calendars.events') }}',
                    drop: function (info) {
                        info.draggedEl.parentNode.removeChild(info.draggedEl);

                        fetch(info.draggedEl.dataset.route, {
                            method: 'PUT',
                            body: JSON.stringify({
                                published_at: info.dateStr
                            }),
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        }).then(function (response) {
                            calendar.removeAllEvents();
                            calendar.refetchEvents();
                        });
                    },
                    eventDrop: function (info) {
                        fetch(info.event.extendedProps.route, {
                            method: 'PUT',
                            body: JSON.stringify({
                                published_at: info.event.startStr
                            }),
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        });
                    },
                });
                calendar.render();
            });
        </script>
    @endpush
</x-app-layout>
