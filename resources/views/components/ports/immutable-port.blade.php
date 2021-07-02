@props(['key', 'port'])

<div
    x-data="immutablePortData({{ $port->id }})"
    class="inline-flex flex-shrink-0 rounded-full items-center py-0.5 pr-3 pl-1 text-sm font-medium cursor-pointer tracking-tighter mr-1 mb-0.5 shadow bg-gray-700 text-gray-50"
    data-qa="tcp-check"
    x-on:mouseenter="hover = true"
    x-on:mouseleave="hover = false"
>
    <div
        class="inline-flex justify-center items-center group"
        x-on:mouseenter="hover = true"
        x-on:mouseleave="hover = false"
        @click="removeImmutablePort"
    >
        <button
            x-on:focus="hover = true"
            x-on:blur="hover = false"
            type="button"
            class="flex flex-shrink-0 justify-center items-center mr-2 w-4 h-4 text-gray-700 bg-gray-50 rounded-full focus:outline-none group-hover:bg-gray-50 group-hover:text-gray-700 focus:bg-gray-50 focus:text-gray-700 focus:ring-4 focus:ring-opacity-70 group-hover:ring-4 group-hover:ring-opacity-70 focus:ring-gray-100 group-hover:ring-gray-100"
            data-qa="remove-tcp-check"
        >
            <span class="sr-only">{{ __('Delete port') }}</span>
            <span class="h-3 w-3">
                <x-heroicon-s-x x-show="hover"/>
                <x-heroicon-s-check x-show="!hover"/>
            </span>
        </button>
    </div>

    <span>{{ $port->portWithService() }}</span>

    <script type="text/javascript">
      window.immutablePortData = function(portId) {
        return {
          hover: false,
          removeImmutablePort() {
            this.$wire.removeImmutablePort(portId);
          },
        }
      }
    </script>
</div>
