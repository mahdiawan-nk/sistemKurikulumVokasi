@props([
    'edit' => null,
    'delete' => null,
])

<td class="p-4">
    <div class="flex items-center gap-2">

        {{-- EDIT --}}
        @if ($edit)
            <button wire:click="{{ $edit }}" type="button"
                class="inline-flex aspect-square items-center justify-center rounded
                       bg-black p-2 text-xs text-white transition hover:opacity-75
                       dark:bg-white dark:text-black">
                <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07
                           a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685
                           a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Z" />
                </svg>
            </button>
        @endif

        {{-- DELETE --}}
        @if ($delete)
            <button wire:click="{{ $delete }}" type="button"
                class="inline-flex aspect-square items-center justify-center rounded
                       bg-red-500 p-2 text-xs text-white transition hover:opacity-75">
                <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21
                           c.342.052.682.107 1.022.166M5.772 5.79
                           l1.068 13.883a2.25 2.25 0 0 0 2.244 2.077h7.832
                           a2.25 2.25 0 0 0 2.244-2.077L18.228 5.79" />
                </svg>
            </button>
        @endif

        {{-- CUSTOM --}}
        {{ $slot }}

    </div>
</td>
