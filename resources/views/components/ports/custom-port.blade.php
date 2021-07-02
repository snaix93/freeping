@props(['key'])

<div
    x-data="customPortBadgeData({ port: @entangle($attributes->wire('model')) })"
    x-show="port !== null"
    x-ref="customPortBadge"
    {{ $attributes->class([
        'inline-flex flex-shrink-0 rounded-full items-center py-0.5 pr-3 pl-1 text-sm font-medium cursor-pointer tracking-tighter mr-1 mb-0.5 shadow',
        'bg-gray-700 text-gray-50 ' => !$errors->has("customPorts.{$key}"),
        'bg-red-500 text-gray-800' => $errors->has("customPorts.{$key}"),
    ]) }}
>
    <div
        class="inline-flex justify-center items-center group"
        x-on:mouseenter="hover = true"
        x-on:mouseleave="hover = false"
        @click="removeCustomPort"
    >
        <button
            x-on:focus="hover = true"
            x-on:blur="hover = false"
            type="button"
            class="flex flex-shrink-0 justify-center items-center mr-2 w-4 h-4 text-gray-700 bg-gray-50 rounded-full focus:outline-none group-hover:bg-gray-50 group-hover:text-gray-700 focus:bg-gray-50 focus:text-gray-700 focus:ring-4 focus:ring-opacity-70 group-hover:ring-4 group-hover:ring-opacity-70 focus:ring-gray-100 group-hover:ring-gray-100"
            data-qa="remove-tcp-check"
        >
            <span class="sr-only">{{ __('Remove custom port for TCP checks') }}</span>

            <span class="h-3 w-3">
                @if ($errors->has("customPorts.{$key}"))
                    <x-heroicon-s-x/>
                @else
                    <x-heroicon-s-x x-show="hover"/>
                    <x-heroicon-s-check x-show="!hover && port && !input"/>
                @endif
            </span>
        </button>
    </div>

    <span
        x-show="!input"
        x-text="port"
        @click="showInput"
    ></span>
    <input
        x-show="input"
        x-model="port"
        type="text"
        x-ref="customPortInput"
        class="bg-white rounded-full text-gray-800 border-0 flex flex-shrink h-full min-w-[75px] outline-none px-2 py-0 w-0"
        placeholder="Port"
        autofocus
        x-on:keydown.enter.stop.prevent="hideInput"
        x-on:change="hideInput"
        x-on:blur="hideInput"
    >

    <script type="text/javascript">
      window.customPortBadgeData = function ({ port }) {
        return {
          port,
          input: true,
          hover: false,
          removeCustomPort() {
            this.$wire.removeCustomPort('{{ $key }}');
          },
          showInput() {
            this.input = true;
            this.$nextTick(() => {
              this.$refs.customPortInput.focus();
              this.$refs.customPortInput.select();
            });
          },
          hideInput() {
            if (!this.port) {
              this.removeCustomPort();
            } else {
              this.input = false;
              this.$wire.$refresh();
            }
          }
        }
      }
    </script>
</div>
