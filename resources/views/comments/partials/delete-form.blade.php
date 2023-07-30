<form method="POST" action="{{ route('comments.destroy', $comment) }}">
    @csrf
    @method('delete')
    <x-dropdown-link :href="route('comments.destroy', $comment)" onclick="event.preventDefault(); this.closest('form').submit();">
        {{ __('Delete') }}
    </x-dropdown-link>
</form>
