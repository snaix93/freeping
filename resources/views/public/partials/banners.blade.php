@switch(true)

    @case(request('verified'))
        <x-banner message="Your email has been successfully verified"/>
        @break

    @case(request('unsubscribed') === 'true' && request('check') === 'ping')
        <x-banner message="Your pinger was stopped successfully"/>
        @break

    @case(request('unsubscribed') === 'true' && request('check') === 'web-check')
        <x-banner message="Your web check was stopped successfully"/>
        @break

    @case(request('unsubscribed') === 'true' && !request()->has('check'))
        <x-banner message="You unsubscribed successfully and all checks were stopped"/>
        @break

@endswitch
