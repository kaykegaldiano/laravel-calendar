<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Calendar') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <form action="{{ route('calendars.update', $calendar) }}" method="post" x-data>
                        @csrf
                        @method('PUT')

                        <label class="form-control w-full mb-4">
                            <div class="label">
                                <span class="label-text">{{ __('Title') }}</span>
                            </div>
                            <input type="text" name="title" placeholder="{{ __('Type here') }}" class="input input-bordered w-full" value="{{ $calendar->title }}" required />
                            @error('title')<small class="text-red-500 mt-1">{{ $message }}</small>@enderror
                        </label>

                        <label class="form-control w-full mb-4">
                            <div class="label">
                                <span class="label-text">{{ __('Description') }}</span>
                            </div>
                            <textarea class="textarea textarea-bordered h-24" name="description" placeholder="{{ __('Description') }}" required>{{ $calendar->description }}</textarea>
                            @error('description')<small class="text-red-500 mt-1">{{ $message }}</small>@enderror
                        </label>

                        <label class="form-control w-full mb-4">
                            <div class="label">
                                <span class="label-text">{{ __('Status') }}</span>
                            </div>
                            <select class="select select-bordered" name="status" required>
                                <option disabled selected>{{ __('Pick one') }}</option>
                                <option value="1" @selected($calendar->status === 1)>{{ __('To Do') }}</option>
                                <option value="2" @selected($calendar->status === 2)>{{ __('Doing') }}</option>
                                <option value="3" @selected($calendar->status === 3)>{{ __('In Revision') }}</option>
                                <option value="4" @selected($calendar->status === 4)>{{ __('Approved') }}</option>
                                <option value="5" @selected($calendar->status === 5)>{{ __('Reproved') }}</option>
                            </select>
                            @error('status')<small class="text-red-500 mt-1">{{ $message }}</small>@enderror
                        </label>

                        <label class="form-control w-full mb-8">
                            <div class="label">
                                <span class="label-text">{{ __('Publish Date') }}</span>
                            </div>
                            <input type="text" x-mask="9999-99-99" name="published_at" class="input input-bordered w-full" value="{{ $calendar->published_at }}" required />
                            @error('publish_date')<small class="text-red-500 mt-1">{{ $message }}</small>@enderror
                        </label>

                        <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>

                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<?php
