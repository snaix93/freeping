<?php


namespace App\Actions\SslCheck;


use App\Models\SslCheck;
use App\Models\WebCheck;

class RegenerateSslDomainListAction
{
    public function __invoke(WebCheck $webCheck)
    {
        $sslCheck = SslCheck::firstOrNew(
            [
                'web_check_id' => $webCheck->id
            ],
            [
                'user_id' => $webCheck->user_id,
            ]
        );
        $sslCheck->fill([
            'host' => $webCheck->host,
            'port' => $webCheck->port ?? 443
        ]);


        if ('https' === $webCheck->protocol) {
            $sslCheck->save();
        } else {
            $sslCheck->delete();
        }
    }
}
