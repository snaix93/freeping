<div
    x-data="{
        type: @entangle('type'),
        selectedType: 0
    }"
>
    <div class="relative h-14 border-b-0 border-gray-100 sm:border-b">
        <div class="flex items-center h-full sm:items-end p-gutter-x">
            <div class="w-full sm:hidden">
                <label for="selected-tab" class="sr-only">Select a tab</label>
                <select
                    x-model="selectedType"
                    @change="type = selectedType"
                    id="selected-tab"
                    name="selected-tab"
                    class="block py-2 pr-10 pl-3 w-full text-base rounded-md border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                >
                    @foreach($types as $value => $text)
                        <option
                            value="{{ $value }}"
                            {{ $type === $value ? 'selected' : '' }}
                        >
                            {{ $text }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="hidden sm:block">
                <nav class="flex -mb-px space-x-8">
                    @foreach($types as $value => $text)
                        <a
                            @click="type = '{{ $value }}'"
                            href="#"
                            class="{{ $type === $value ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}  whitespace-nowrap pb-4 px-1 border-b-2 font-medium text-sm"
                            aria-current="page"
                            data-qa="problem-tab-{{ Str::lower($value) }}"
                        >
                            {{ $text }}
                        </a>
                    @endforeach
                </nav>
            </div>
        </div>
    </div>

    <div class="overflow-hidden bg-white">
        <ul class="border-b border-gray-100 divide-y divide-gray-100">
            @each('livewire.problem.partials.problem-list-item', $problems, 'problem')
        </ul>

        @if ($problems->hasPages())
            <div class="py-2 bg-white bg-gray-50 bg-opacity-25 border-b border-gray-100 p-gutter-x">
                {{ $problems->links() }}
            </div>
        @endif
    </div>

    <x-last-refreshed/>
</div>
