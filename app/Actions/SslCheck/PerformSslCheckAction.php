<?php


namespace App\Actions\SslCheck;


use App\Data\Events\MonitoringEventData;
use App\Enums\EventOriginator;
use App\Enums\SslCertificateStatus;
use App\Events\Monitoring\Problem;
use App\Events\Monitoring\Recovery;
use App\Exceptions\SslCertificateCheckException;
use App\Models\SslCheck;
use App\Models\User;
use App\Support\SslCertificateInfoService;
use Carbon\Carbon;

class PerformSslCheckAction
{
    private User $user;

    public function __invoke(SslCheck $sslCheck, SslCertificateInfoService $sslCertificateInfoService)
    {
        $this->user = $sslCheck->user;
        if (!$this->user->enabledSslAlerts() && !$this->user->enabledSslWarnings()) {
            logger("User has ssl alerting disabled");
            return;
        }
        try {
            $expirationDate = $sslCertificateInfoService->getExpiryDate($sslCheck->host, $sslCheck->port);
        }catch (SslCertificateCheckException $exception){
            $sslCheck->certificate_status = SslCertificateStatus::AwaitingResult();
            $sslCheck->last_error_text = $exception->getMessage();
            $sslCheck->save();

            return;
        }

        $sslCheck->certificate_expires_at = $expirationDate;
        $sslCheck->last_check_received_at = Carbon::now();
        $sslCheck->certificate_status = $expirationDate->greaterThan(now()) ? SslCertificateStatus::Valid() : SslCertificateStatus::Expired();

        if($this->user->enabledSslAlerts() ) {
            $isExpiringSoon = $expirationDate->isBefore(
                now()->addDays($this->user->ssl_alert_threshold)
            );
            $notIsExpiringSoon = ! $isExpiringSoon;

            if ($isExpiringSoon && ! $sslCheck->hasActiveAlert()) {
                $this->makeProblem($sslCheck, $expirationDate, 'alert');
                $sslCheck->alerted_at = now();
            }
            if ($notIsExpiringSoon && $sslCheck->hasActiveAlert()) {
                $this->makeRecovery($sslCheck, $expirationDate, 'alert');
                $sslCheck->alerted_at = null;
            }
        }

        if($this->user->enabledSslWarnings()) {
            $isExpiringSoon = $expirationDate->isBefore(
                now()->addDays($this->user->ssl_warning_threshold)
            );
            $notIsExpiringSoon = ! $isExpiringSoon;

            if ($isExpiringSoon && ! $sslCheck->hasActiveWarning()) {
                $this->makeProblem($sslCheck, $expirationDate, 'warning');
                $sslCheck->warned_at = now();
            }
            if ($notIsExpiringSoon && $sslCheck->hasActiveWarning()) {
                $this->makeRecovery($sslCheck, $expirationDate, 'warning');
                $sslCheck->warned_at = null;
            }
        }

        $sslCheck->save();
    }

    private function makeProblem(SslCheck $sslCheck, Carbon $expirationDate, string $severity){
        $problemEvent = MonitoringEventData::create(EventOriginator::SslCheck(), [
            'connect'     => $sslCheck->host,
            'severity'    => $severity,
            'type'        => 'SSL Certificate problem',
            'description' => sprintf('SSL Certificate has expired or expires soon'),
            'meta'        => [
                'domainExpiresAt'   => $expirationDate->diffForHumans(),
                'domainExpiresAtUtc' => $expirationDate->utc(),
            ],
        ]);
        event(new Problem($this->user, $problemEvent));
    }

    private function makeRecovery(SslCheck $sslCheck, Carbon $expirationDate, string $severity){
        $problemEvent = MonitoringEventData::create(EventOriginator::SslCheck(), [
            'connect'     => $sslCheck->host,
            'severity'    => $severity,
            'type'        => 'SSL Certificate recovery',
            'description' => sprintf('SSL Certificate is no longer expired and not expires soon'),
            'meta'        => [
                'domainExpiresAt'   => $expirationDate->diffForHumans(),
                'domainExpiresAtUtc' => $expirationDate->utc(),
            ],
        ]);
        event(new Recovery($this->user, $problemEvent));
    }
}
