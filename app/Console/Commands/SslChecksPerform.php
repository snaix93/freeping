<?php

namespace App\Console\Commands;

use App\Actions\SslCheck\PerformSslCheckAction;
use App\Models\SslCheck;
use App\Support\SslCertificateInfoService;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;

class SslChecksPerform extends Command
{
    protected $signature = 'ssl-checks:perform';

    protected $description = 'Runs SSL certificate expiry date check';

    public function __construct(private SslCertificateInfoService $sslCertificateInfoService)
    {
        parent::__construct();
    }


    public function handle()
    {

        $this->process();

        return 0;
    }

    private function process(){
        SslCheck::query()->whereHas('user',function (Builder $query){
           $query->where('ssl_alert_threshold','!=', 0)
               ->orWhere('ssl_warning_threshold','!=', 0);
        })
            ->cursor()->each(function(SslCheck $sslCheck){
                $this->info($sslCheck->host);
                resolve(PerformSslCheckAction::class)($sslCheck, $this->sslCertificateInfoService);
        });
    }
}
