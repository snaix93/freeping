<?php

namespace App\Providers;

use App\Actions\SslCheck\PerformSslCheckAction;
use App\Events\Monitoring\Defect;
use App\Events\Monitoring\Problem;
use App\Events\Monitoring\Recovery;
use App\Events\SslCheck\SslCheckCreated;
use App\Events\WebCheck\WebCheckCreated;
use App\Events\WebCheck\WebCheckDeleted;
use App\Events\WebCheck\WebCheckUpdated;
use App\Listeners\EvaluateCompletedPingBatchResults;
use App\Listeners\EvaluateCompletedScanBatchResults;
use App\Listeners\EvaluateCompletedWebCheckBatchResults;
use App\Listeners\LogPingStatistics;
use App\Listeners\LogScanStatistics;
use App\Listeners\LogWebCheckStatistics;
use App\Listeners\Monitoring\DefectListener;
use App\Listeners\Monitoring\ProblemListener;
use App\Listeners\Monitoring\RecoveryListener;
use App\Listeners\SslCheck\PerformSslCheckOnCreation;
use App\Listeners\WebCheck\RegenerateSSLDomainsList;
use App\Support\CallbackProcessor\Events\BatchComplete;
use App\Support\CallbackProcessor\Events\Ping\PingBatchComplete;
use App\Support\CallbackProcessor\Events\Ping\PingResultReceived;
use App\Support\CallbackProcessor\Events\Scan\ScanBatchComplete;
use App\Support\CallbackProcessor\Events\Scan\ScanResultReceived;
use App\Support\CallbackProcessor\Events\WebCheck\WebCheckBatchComplete;
use App\Support\CallbackProcessor\Events\WebCheck\WebCheckResultReceived;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [

        Problem::class => [
            ProblemListener::class,
        ],

        Recovery::class => [
            RecoveryListener::class,
        ],

        Defect::class => [
            DefectListener::class,
        ],

        PingResultReceived::class => [
            LogPingStatistics::class,
        ],

        PingBatchComplete::class => [
            EvaluateCompletedPingBatchResults::class,
        ],

        ScanResultReceived::class => [
            LogScanStatistics::class,
        ],

        ScanBatchComplete::class => [
            EvaluateCompletedScanBatchResults::class,
        ],

        WebCheckResultReceived::class => [
            LogWebCheckStatistics::class,
        ],

        WebCheckBatchComplete::class => [
            EvaluateCompletedWebCheckBatchResults::class,
        ],

        BatchComplete::class   => [],


        /* WEB CHECK EVENTS */
        WebCheckCreated::class => [
            RegenerateSSLDomainsList::class,
        ],
        WebCheckUpdated::class => [
            RegenerateSSLDomainsList::class,
        ],


        SslCheckCreated::class => [
            PerformSslCheckOnCreation::class
        ]
    ];

    public function boot()
    {

    }
}
