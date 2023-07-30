<form method="POST" action="{{ route('messages.destroy', $message) }}">
    @csrf
    @method('delete')
    <x-dropdown-link :href="route('messages.destroy', $message)" onclick="event.preventDefault(); this.closest('form').submit();">
        {{ __('Delete') }}
    </x-dropdown-link>
</form>
