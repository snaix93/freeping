@props(['status'])

@switch($status)
    @case(\App\Enums\SslCertificateStatus::AwaitingResult)
    <x-tiny-pulse-status color="gray"/>
    @break
    @case(\App\Enums\SslCertificateStatus::Valid)
    <x-tiny-pulse-status color="green"/>
    @break
    @case(\App\Enums\SslCertificateStatus::Expired)
    <x-tiny-pulse-status color="red"/>
    @break
@endswitch
