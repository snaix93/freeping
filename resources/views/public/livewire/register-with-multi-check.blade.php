<div
    id="MultiCheckForm"
    class="mx-2 space-y-2 max-w-4xl md:mx-auto"
    x-data="createMultiCheckData()"
    @connect-valid.window="runDiscoveryProcess"
    @connect-invalid.window="reset"
    @reset.window="reset"
>
    <a
        href="#"
        class="flex justify-end items-center pr-2 space-x-2 text-xs font-bold text-white uppercase md:text-sm group md:pr-0"
        wire:click="$toggle('showHowItWorksVideo')"
    >
        <x-heroicon-o-play
            class="w-5 h-5 group-hover:text-gray-100"
        />
        <span class="group-hover:text-gray-100">{{ __('How does this work?') }}</span>
    </a>

    <x-show-video-modal wire:model="showHowItWorksVideo"/>

    <div class="bg-white rounded-md border-l-[15px] w-full border-blue-800 overflow-hidden shadow-md flex flex-col">

        <x-pinger-created-banner
            message="{{ __('Your checks were successfully created!') }} {{ __('Check your inbox.') }}"
            class="rounded-none"
        />

        <div class="flex flex-col justify-center py-6 px-8 space-y-1 w-full bg-gray-50">
            <div class="text-base font-medium text-gray-800 uppercase">
                {{ __('Enter your IP, FQDN or url to get started') }}
            </div>
            <div class="text-sm text-gray-600">
                {{ __('We’ll run some checks and suggest the monitoring we think you need...') }}
            </div>
        </div>

        <div class="flex-1">
            <div class="flex flex-col py-6 px-8 border-t border-gray-100">

                <x-connect-field/>

                <div
                    x-show="!isDiscovering"
                    class="text-sm text-blue-500 hover:text-blue-700 mt-2 text-right"
                >
                    <a href="{{ route('register') }}">
                        or just signup for our intranet/private server monitoring services
                    </a>
                </div>

            </div>

            <div
                x-show="isDiscovering"
                x-cloak
                class="flex overflow-hidden flex-col py-6 px-8 space-y-2 bg-gray-50 border-t border-b border-gray-100"
            >
                <div
                    x-show="discoverySteps.targetVerification.show"
                    class="flex items-center space-x-4 w-full sm:w-2/3 md:w-1/2"
                >
                    <div class="flex-1 text-base text-gray-800">
                        {{ __('Verifying target') }}
                    </div>
                    <div x-show="!discoverySteps.targetVerification.complete">
                        <x-loading-spinner class="w-8 h-8"/>
                    </div>
                    <div x-show="discoverySteps.targetVerification.complete">
                        <x-heroicon-s-check class="w-8 h-8 text-green-500"/>
                    </div>
                </div>
                <div
                    x-show="discoverySteps.portScan.show"
                    class="flex items-center space-x-4 w-full sm:w-2/3 md:w-1/2"
                >
                    <div class="flex-1 text-base text-gray-800">
                        {{ __('Scanning ports') }}
                    </div>
                    <div x-show="!discoverySteps.portScan.complete">
                        <x-loading-spinner class="w-8 h-8"/>
                    </div>
                    <div x-show="discoverySteps.portScan.complete">
                        <x-heroicon-s-check class="w-8 h-8 text-green-500"/>
                    </div>
                </div>
                <div
                    x-show="discoverySteps.webCheckScan.show"
                    class="flex items-center space-x-4 w-full sm:w-2/3 md:w-1/2"
                >
                    <div class="flex-1 text-base text-gray-800">
                        {{ __('Searching for valid web checks') }}
                    </div>
                    <div x-show="!discoverySteps.webCheckScan.complete">
                        <x-loading-spinner class="w-8 h-8"/>
                    </div>
                    <div x-show="discoverySteps.webCheckScan.complete">
                        <x-heroicon-s-check class="w-8 h-8 text-green-500"/>
                    </div>
                </div>
                <div
                    x-show="discoverySteps.preparingResults.show"
                    class="flex items-center space-x-4 w-full sm:w-2/3 md:w-1/2"
                >
                    <div class="flex-1 text-base text-gray-800">
                        {{ __('Preparing recommendations') }}
                    </div>
                    <div x-show="!discoverySteps.preparingResults.complete">
                        <x-loading-spinner class="w-8 h-8"/>
                    </div>
                    <div x-show="discoverySteps.preparingResults.complete">
                        <x-heroicon-s-check class="w-8 h-8 text-green-500"/>
                    </div>
                </div>
            </div>

            <form
                wire:submit.prevent="save"
                x-show="hasResults && !isDiscovering"
                x-cloak
            >
                @if(Honey::isEnabled())
                    <x-honey recaptcha/>
                @endif
                @if ($this->showResults)
                    <div class="flex flex-col py-6 px-8 space-y-4 bg-gray-50 bg-opacity-50 border-t border-b border-gray-100">
                        <div class="text-xs font-medium text-gray-900 uppercase">
                            {{ __('After scanning your host these are our monitoring recommendations') }}
                        </div>
                        <div class="flex flex-col -mt-2 space-y-4 divide-y divide-gray-100">
                            @if($includePing)
                                <div class="pt-4 space-y-3 sm:grid sm:grid-cols-4 sm:gap-x-3 sm:gap-y-1 sm:items-start sm:space-y-0">
                                    <div class="flex h-full">
                                        <x-tooltip>
                                            <div class="flex flex-shrink items-center space-x-2">
                                                <x-heroicon-s-information-circle
                                                    class="w-5 h-5 text-blue-500"
                                                />
                                                <div class="text-sm text-gray-900">
                                                    {{ __('ICMP Ping') }}
                                                </div>
                                            </div>
                                            <x-slot name="content">
                                                {{ __('In simple terms, an ICMP ping check works very much like echo-location on a submarine. To determine the reachability of your server, we will ping out a small packet of data to your IP/FQDN, and listen out for the reply. When we receive the reply, we know your server is up and listening.') }}
                                            </x-slot>
                                        </x-tooltip>
                                    </div>
                                    <div class="relative mt-1 sm:mt-0 sm:col-span-3">
                                        <div
                                            class="text-sm text-gray-700"
                                            data-qa="ping-result"
                                        >
                                            {{ $pingTarget }}
                                            @if($this->pingResolvable)
                                                <span class="ml-0.5 text-green-600 font-semibold">
                                                    {{ __('is alive') }}
                                                </span>
                                            @else
                                                <span class="ml-0.5 text-red-500 font-semibold">
                                                    {{ __('is unreachable') }}
                                                </span>
                                            @endif
                                        </div>
                                        <input
                                            wire:model.lazy="pingTarget"
                                            type="hidden"
                                            class="block w-full text-gray-600 bg-gray-50 rounded-md border-gray-200 shadow-sm sm:text-sm"
                                            disabled
                                        >
                                        @error('pingTarget')
                                        <div class="text-sm text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            @endif
                            @if($includePorts)
                                <div class="pt-4 space-y-3 sm:grid sm:grid-cols-4 sm:gap-x-3 sm:gap-y-1 sm:items-start sm:space-y-0">
                                    <div class="flex h-full">
                                        <x-tooltip>
                                            <div class="flex flex-shrink items-center space-x-2">
                                                <x-heroicon-s-information-circle
                                                    class="w-5 h-5 text-blue-500"
                                                />
                                                <div class="text-sm text-gray-900">
                                                    {{ __('TCP Checks') }}
                                                </div>
                                            </div>
                                            <x-slot name="content">
                                                {{ __('Monitor TCP connectivity for chosen host. We will scan for open ports and offer them as the defaults. You are welcome to add custom ports to suit your needs, or disable completely by unselecting all the ports.') }}
                                            </x-slot>
                                        </x-tooltip>
                                    </div>
                                    <div class="relative mt-1 sm:mt-0 sm:col-span-3">
                                        <x-tcp-ports
                                            :ports="$this->ports"
                                            :open-ports="$this->openPorts"
                                            :custom-ports="$this->customPorts"
                                        />
                                    </div>
                                </div>
                            @endif
                            @if($includeWebChecks)
                                <div class="pt-4 space-y-3 sm:grid sm:grid-cols-4 sm:gap-x-3 sm:gap-y-1 sm:items-start sm:space-y-0">
                                    <div class="flex h-full">
                                        <x-tooltip>
                                            <div class="flex flex-shrink items-center space-x-2">
                                                <x-heroicon-s-information-circle
                                                    class="w-5 h-5 text-blue-500"
                                                />
                                                <div class="text-sm text-gray-900">
                                                    {{ __('Web Checks') }}
                                                </div>
                                            </div>
                                            <x-slot name="content">
                                                {{ __('We will ping your website from multiple locations, and perform checks as defined here. We will alert you accordingly if the check fails. You can add additional parameters to these checks from within the dashboard.') }}
                                            </x-slot>
                                        </x-tooltip>
                                    </div>
                                    <div class="relative mt-1 sm:-mt-2 sm:col-span-3">
                                        <x-web-checks
                                            :connect="$this->connect"
                                            :web-checks="$this->webChecks"
                                        />
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="py-6 px-8 bg-white shadow">
                        @guest()
                            <div class="mb-6 space-y-2">
                                <div class="sm:grid sm:grid-cols-4 sm:gap-x-3 sm:gap-y-1 sm:items-start sm:pt-2">
                                    <div class="flex items-center h-full">
                                        <label
                                            for="email"
                                            class="text-base text-gray-700"
                                        >
                                            {{ __('Enter your email') }}
                                        </label>
                                    </div>
                                    <div class="relative mt-1 sm:mt-0 sm:col-span-3">
                                        <input
                                            wire:model.lazy="email"
                                            type="text"
                                            name="email"
                                            id="email"
                                            class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                            placeholder="alerts@example.com"
                                        >
                                    </div>
                                    @error('email')
                                    <div class="text-sm text-red-500 sm:col-start-2 sm:col-span-2">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="sm:grid sm:grid-cols-4 sm:gap-x-3 sm:gap-y-1 sm:items-start sm:pt-2">
                                    <div class="flex items-center h-full">
                                        <label
                                            for="time"
                                            class="text-base text-gray-700"
                                        >
                                            {{ __('Daily report sent at') }}
                                        </label>
                                    </div>
                                    <div class="mt-1 space-y-2 sm:col-span-3 sm:mt-0 sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:space-y-0">
                                        <div class="sm:col-span-1">
                                            <label for="time" class="sr-only"></label>
                                            <select
                                                wire:model.defer="time"
                                                id="time"
                                                name="time"
                                                class="block py-2 pr-10 pl-3 w-full text-base rounded-md border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                            >
                                                @foreach($this->periods as $period)
                                                    <option value="{{ $period['value'] }}">
                                                        {{ $period['text'] }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="sm:col-span-2">
                                            <label for="timezone" class="sr-only"></label>
                                            <select
                                                wire:model.defer="timezone"
                                                id="timezone"
                                                name="timezone"
                                                class="block py-2 pr-10 pl-3 w-full text-base rounded-md border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                            >
                                                @foreach($this->timezones as $_timezone)
                                                    <option value="{{ $_timezone['value'] }}">
                                                        ({{ $_timezone['offset'] }}) {{ $_timezone['value'] }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    @if ($errors->has('time') || $errors->has('timezone'))
                                        <div class="sm:col-start-2 sm:col-span-2 sm:grid sm:grid-cols-3 sm:gap-4">
                                            <div class="sm:col-span-1">
                                                @error('time')
                                                <span class="text-sm text-red-500">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="sm:col-span-2">
                                                @error('timezone')
                                                <span class="text-sm text-red-500">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <div class="sm:grid sm:grid-cols-4 sm:gap-2 sm:items-start sm:pt-2">
                                    <div class="mt-1 sm:mt-0 sm:col-span-3 sm:col-start-2">
                                        <div class="flex items-center">
                                            <input
                                                wire:model.defer="terms"
                                                id="terms"
                                                name="terms"
                                                type="checkbox"
                                                class="w-4 h-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500"
                                            >
                                            <label
                                                for="terms"
                                                class="block ml-2 text-sm text-gray-900"
                                            >
                                                {{ __('I accept the') }} <a class="underline"
                                                                            href="https://www.cloudradar.io/service-terms"
                                                                            target="_blank">{{ __('terms and conditions') }}</a>
                                            </label>
                                        </div>
                                        @error('terms')
                                        <span class="text-sm text-red-500">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        @endguest()

                        <div class="flex justify-center items-center mx-auto max-w-xs">
                            <button
                                wire:loading.delay.attr="disabled"
                                wire:target="save"
                                wire:loading.delay.class.add="disabled:cursor-not-allowed disabled:bg-gray-100 disabled:text-white"
                                type="submit"
                                class="inline-flex justify-center items-center py-2 px-4 w-full text-base text-xl font-medium text-white uppercase bg-blue-600 rounded-md border border-transparent shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                            >
                                <span
                                    wire:loading.delay.class="hidden"
                                    wire:target="save"
                                >
                                    {{ __('Start') }}
                                </span>
                                <span
                                    wire:loading.delay.class.remove="hidden"
                                    wire:target="save"
                                    class="hidden"
                                    wire:loading.attr="data-qa-spinner"
                                >
                                    <svg
                                        class="mr-3 -ml-1 w-8 h-8 text-blue-700 animate-spin"
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 24 24"
                                    >
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                                stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor"
                                              d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                </span>
                            </button>
                        </div>
                    </div>
                @endif
            </form>
        </div>

    </div>
</div>

<script type="text/javascript">
  window.createMultiCheckData = function() {
    return {
      isDiscovering: false,
      hasResults: false,
      discoverySteps: {
        targetVerification: { showAt: 0, show: false, complete: false },
        portScan: { showAt: 800, show: false, complete: false },
        webCheckScan: { showAt: 1600, show: false, complete: false },
        preparingResults: { showAt: 2400, show: false, complete: false },
      },
      completeAt: 3200,
      discoveryInterval: null,
      async runDiscoveryProcess({ detail: connect }) {
        this.reset();
        this._startDiscoveryVisuals();
        await this.$wire.discover(connect);
        this.hasResults = true;
      },
      reset() {
        this.hasResults = false;
        this._endDiscoveryVisuals();
      },
      _startDiscoveryVisuals() {
        this.isDiscovering = true;

        let tick = 0;
        let showNextTick = 'targetVerification';
        this.discoveryInterval = setInterval(() => {

          if (showNextTick) {
            this.discoverySteps[showNextTick].show = true;
            showNextTick = null;
          }

          let prevRef = null;
          Object.keys(this.discoverySteps).forEach(ref => {
            const { showAt, show } = this.discoverySteps[ref];

            if (tick >= showAt && !show) {
              if (prevRef) {
                showNextTick = ref;
                this.discoverySteps[prevRef].complete = true;
              } else {
                this.discoverySteps[ref].show = true;
              }
            }

            prevRef = ref;
          });

          if (tick > this.completeAt && this.hasResults) {
            this.discoverySteps[prevRef].complete = true;
            this._endDiscoveryVisuals();
          }

          tick += 100;
        }, 100);
      },
      _endDiscoveryVisuals() {
        this.isDiscovering = false;
        clearInterval(this.discoveryInterval);
        setTimeout(() => {
          Object.keys(this.discoverySteps).forEach(ref => {
            this.discoverySteps[ref].show = false;
            this.discoverySteps[ref].complete = false;
          });
        }, 500);
      }
    }
  }
</script>
