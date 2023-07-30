<x-app-layout>
    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
        <div class="mt-6 bg-white shadow-sm rounded-lg divide-y">
            <form method="post" action="{{ route('messages.store') }}" class="p-6">
                @csrf
                <div class="mt-6">
                    <textarea
                        name="body"
                        placeholder="{{ __('What\'s your message?') }}"
                        class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                    >{{ old('message') }}</textarea>
                    <x-input-error :messages="$errors->get('body')" class="mt-2" />
                </div>

                <div class="mt-6 flex justify-end">
                    @include('messages.partials.cancel-link')
                    <x-primary-button class="ml-3">
                        {{ __('Post Message') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
