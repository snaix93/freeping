<?php


namespace App\Listeners\SslCheck;


use App\Actions\SslCheck\PerformSslCheckAction;
use App\Events\SslCheck\SslCheckCreated;
use App\Support\SslCertificateInfoService;

class PerformSslCheckOnCreation
{
    public function __construct(protected SslCertificateInfoService $sslCertificateInfoService)
    {
    }


    public function handle(SslCheckCreated $sslCheckCreated)
    {
        resolve(PerformSslCheckAction::class)($sslCheckCreated->sslCheck, $this->sslCertificateInfoService);
    }

}
