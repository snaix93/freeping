<nav x-data="{ open: false }" class="flex-shrink-0 bg-blue-700">

    <div class="mx-auto max-w-7xl p-gutter-x">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="flex flex-shrink-0 items-center">
                    <a href="{{ route('pingers') }}">
                        <x-jet-application-mark class="block w-auto h-9"/>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-jet-nav-link
                        href="{{ route('problems') }}"
                        :active="request()->routeIs('problems')"
                    >
                        {{ __('Problems') }}
                    </x-jet-nav-link>
                    <x-jet-nav-link
                        href="{{ route('pingers') }}"
                        :active="request()->routeIs('pingers')"
                    >
                        {{ __('Pingers') }}
                    </x-jet-nav-link>
                    <x-jet-nav-link
                        href="{{ route('web-checks') }}"
                        :active="request()->routeIs('web-checks')"
                    >
                        {{ __('Web Checks') }}
                    </x-jet-nav-link>
                    <x-jet-nav-link
                        href="{{ route('pulses') }}"
                        :active="request()->routeIs('pulses')"
                    >
                        {{ __('Pulses') }}
                    </x-jet-nav-link>
                    <x-jet-nav-link
                        href="{{ route('captures') }}"
                        :active="request()->routeIs('captures')"
                    >
                        {{ __('Captures') }}
                    </x-jet-nav-link>
                    <x-jet-nav-link
                        href="{{ route('ssl-certificates') }}"
                        :active="request()->routeIs('ssl-certificates')"
                    >
                        {{ __('SSL Certificates') }}
                    </x-jet-nav-link>
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <!-- Settings Dropdown -->
                <div class="relative ml-3">
                    <x-jet-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                <button
                                    class="flex text-sm rounded-full border-2 border-transparent transition duration-150 ease-in-out focus:outline-none focus:border-gray-300"
                                    data-qa="btn-dropdown"
                                >
                                    <img class="object-cover w-8 h-8 rounded-full"
                                         src="{{ Auth::user()->profile_photo_url }}"
                                         alt="{{ Auth::user()->name }}"/>
                                </button>
                            @else
                                <span class="inline-flex rounded-md">
                                    <button
                                        type="button"
                                        class="inline-flex items-center py-2 px-3 text-sm font-medium leading-4 text-white bg-blue-700 rounded-md border border-transparent transition duration-150 ease-in-out hover:text-gray-100 focus:outline-none"
                                        data-qa="btn-dropdown"
                                    >
                                        {{ Auth::user()->name }}

                                        <svg class="ml-2 -mr-0.5 h-6 w-6"
                                             xmlns="http://www.w3.org/2000/svg"
                                             viewBox="0 0 20 20"
                                             fill="currentColor">
                                            <path fill-rule="evenodd"
                                                  d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                  clip-rule="evenodd"/>
                                        </svg>
                                    </button>
                                </span>
                            @endif
                        </x-slot>

                        <x-slot name="content">
                            <!-- Account Management -->
                            <div class="block py-2 px-4 text-xs text-gray-400">
                                {{ __('Manage Account') }}
                            </div>

                            <x-jet-dropdown-link href="{{ route('profile.show') }}">
                                {{ __('Profile') }}
                            </x-jet-dropdown-link>

                            <x-jet-dropdown-link href="{{ route('settings.show') }}">
                                {{ __('Settings') }}
                            </x-jet-dropdown-link>

                            @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                                <x-jet-dropdown-link href="{{ route('api-tokens.index') }}">
                                    {{ __('API Tokens') }}
                                </x-jet-dropdown-link>
                            @endif

                            <div class="border-t border-gray-100"></div>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-jet-dropdown-link href="{{ route('logout') }}"
                                                     onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-jet-dropdown-link>
                            </form>
                        </x-slot>
                    </x-jet-dropdown>
                </div>
            </div>

            <!-- Hamburger -->
            <div class="flex items-center -mr-2 sm:hidden">
                <button @click="open = ! open"
                        class="inline-flex justify-center items-center p-2 text-gray-400 rounded-md transition duration-150 ease-in-out hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500">
                    <svg class="w-6 h-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }"
                              class="inline-flex"
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16"/>
                        <path :class="{'hidden': ! open, 'inline-flex': open }"
                              class="hidden"
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-jet-responsive-nav-link
                href="{{ route('problems') }}"
                :active="request()->routeIs('problems')"
            >
                {{ __('Problems') }}
            </x-jet-responsive-nav-link>
            <x-jet-responsive-nav-link
                href="{{ route('pingers') }}"
                :active="request()->routeIs('pingers')"
            >
                {{ __('Pingers') }}
            </x-jet-responsive-nav-link>
            <x-jet-responsive-nav-link
                href="{{ route('web-checks') }}"
                :active="request()->routeIs('web-checks')"
            >
                {{ __('Web Checks') }}
            </x-jet-responsive-nav-link>
            <x-jet-responsive-nav-link
                href="{{ route('pulses') }}"
                :active="request()->routeIs('pulses')"
            >
                {{ __('Pulses') }}
            </x-jet-responsive-nav-link>
            <x-jet-responsive-nav-link
                href="{{ route('ssl-certificates') }}"
                :active="request()->routeIs('ssl-certificates')"
            >
                {{ __('SSL Certificates') }}
            </x-jet-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="flex items-center px-4">
                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                    <div class="flex-shrink-0 mr-3">
                        <img class="object-cover w-10 h-10 rounded-full"
                             src="{{ Auth::user()->profile_photo_url }}"
                             alt="{{ Auth::user()->name }}"/>
                    </div>
                @endif

                <div class="">
                    <div class="text-base font-medium text-white">{{ Auth::user()->name }}</div>
                    <div class="text-sm font-medium text-blue-200">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <!-- Account Management -->
                <x-jet-responsive-nav-link href="{{ route('profile.show') }}"
                                           :active="request()->routeIs('profile.show')">
                    {{ __('Profile') }}
                </x-jet-responsive-nav-link>

                <x-jet-responsive-nav-link href="{{ route('settings.show') }}"
                                           :active="request()->routeIs('settings.show')">
                    {{ __('Settings') }}
                </x-jet-responsive-nav-link>

                @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                    <x-jet-responsive-nav-link href="{{ route('api-tokens.index') }}"
                                               :active="request()->routeIs('api-tokens.index')">
                        {{ __('API Tokens') }}
                    </x-jet-responsive-nav-link>
                @endif

            <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-jet-responsive-nav-link href="{{ route('logout') }}"
                                               onclick="event.preventDefault();
                                    this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-jet-responsive-nav-link>
                </form>

                <!-- Team Management -->
                @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                    <div class="border-t border-gray-200"></div>

                    <div class="block py-2 px-4 text-xs text-gray-400">
                        {{ __('Manage Team') }}
                    </div>

                    <!-- Team Settings -->
                    <x-jet-responsive-nav-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}"
                                               :active="request()->routeIs('teams.show')">
                        {{ __('Team Settings') }}
                    </x-jet-responsive-nav-link>

                    @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                        <x-jet-responsive-nav-link href="{{ route('teams.create') }}"
                                                   :active="request()->routeIs('teams.create')">
                            {{ __('Create New Team') }}
                        </x-jet-responsive-nav-link>
                    @endcan

                    <div class="border-t border-gray-200"></div>

                    <!-- Team Switcher -->
                    <div class="block py-2 px-4 text-xs text-gray-400">
                        {{ __('Switch Teams') }}
                    </div>

                    @foreach (Auth::user()->allTeams() as $team)
                        <x-jet-switchable-team :team="$team" component="jet-responsive-nav-link"/>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</nav>
