<form>
    <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-4">
        <div class="relative flex-1">
            <label for="connect" class="sr-only">
                {{ __('Enter your IP, FQDN or url to get started') }}
            </label>
            <x-heroicon-s-chevron-right
                class="flex absolute left-2 items-center w-6 h-6 h-11 text-gray-300 pointer-events-none hover:text-blue-700"
            />
            <input
                wire:model.defer="connect"
                wire:keydown.enter.stop.prevent="validateConnect"
                type="text"
                name="connect"
                id="connect"
                class="block pr-10 pl-10 w-full h-11 rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm disabled:bg-gray-50 disabled:text-gray-500"
                placeholder="Enter your IP, FQDN or url"
                :disabled="isDiscovering"
            >
            <x-input-spinner/>
        </div>
        <button
            wire:click.stop.prevent="validateConnect"
            wire:loading.attr="disabled"
            wire:loading.class.add="disabled:cursor-not-allowed disabled:bg-none disabled:bg-gray-100 disabled:text-white"
            type="button"
            class="inline-flex h-12 sm:h-auto min-w-[150px] justify-center items-center py-2 px-3 text-base font-medium leading-4 text-white bg-blue-800 bg-gradient-to-r from-blue-800 to-blue-500 rounded-md shadow-sm hover:bg-blue-600 hover:bg-none focus:bg-blue-700 focus:bg-none focus:outline-none focus:ring-2 focus:ring-offset-1 focus:ring-blue-500 disabled:bg-gray-200 disabled:bg-none disabled:text-gray-600"
            :disabled="isDiscovering"
            data-qa="discover-connect"
        >
            <x-loading-spinner x-show="isDiscovering" class="!text-gray-800"/>
            <span x-show="!isDiscovering">Discover</span>
        </button>
    </div>
    @error('connect')
    <div class="text-sm text-red-500">
        {{ $message }}
    </div>
    @enderror
</form>
