<?php

namespace App\Console\Commands;

use App\Data\Events\MonitoringEventData;
use App\Enums\EventOriginator;
use App\Events\Monitoring\Problem;
use App\Events\Monitoring\Recovery;
use App\Models\Pulse;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class PulseProcess extends Command
{
    protected $signature = 'pulse:process {--D|daemon}';

    protected $description = 'Look for lost and recovered pulses';

    public function handle()
    {
        if ($this->option('daemon')) {
            /*
             * The daemon option is for local testing only.
             * This command is meant to be executed by the short schedule worker. See Commands/kernel.php
             */
            while (true) {
                $this->process();
                sleep(45);
            }
        } else {
            $this->process();
        }

        return 0;
    }

    private function process()
    {
        $this->processPulseRecovered();
        $this->processPulseLost();
    }

    private function processPulseRecovered(): void
    {
        $sql = "SELECT u.id as user_id, u.pulse_threshold, p.*
                FROM pulses p
                JOIN users u ON (u.id = p.user_id)
                WHERE p.alerted_at IS NOT NULL
                AND u.pulse_threshold > 0
                AND p.last_pulse_received_at > NOW() - INTERVAL u.pulse_threshold SECOND";
        $records = DB::select($sql);
        $this->line(sprintf("%d host(s) without pulse recovered.\n", count($records)), null, 'v');
        foreach ($records as $record) {
            $lastPulseReceived = new Carbon($record->last_pulse_received_at);
            $monitoringEvent = MonitoringEventData::create(EventOriginator::Pulse(), [
                'eventId'     => $record->event_id,
                'connect'     => $record->hostname,
                'type'        => 'Pulse Recovered',
                'description' => 'Your host is sending a pulse again',
                'meta'        => [
                    'lastPulseReceived'      => $lastPulseReceived->diffForHumans(),
                    'lastPulseReceivedAtUtc' => $record->last_pulse_received_at,
                    'lastPulseReceivedFrom'  => $record->last_remote_address,
                    'hostDescription'        => $record->description,
                    'hostLocation'           => $record->location,
                ],
            ]);
            Pulse::whereId($record->id)->firstOrFail()->unmarkAlerted();
            event(new Recovery($record->user_id, $monitoringEvent));
        }
    }

    /**
     * Look for all hosts that have stopped sending the pulse and send a notification to the owner (user) of the hosts
     */
    private function processPulseLost(): void
    {
        $sql = "SELECT u.id as user_id, u.pulse_threshold, p.*
                FROM pulses p
                JOIN users u ON (u.id = p.user_id)
                WHERE p.alerted_at IS NULL
                AND u.pulse_threshold > 0
                AND p.last_pulse_received_at < NOW() - INTERVAL u.pulse_threshold SECOND";
        $records = DB::select($sql);
        $this->line(sprintf("%d host(s) without pulse detected.\n", count($records)), null, 'v');
        foreach ($records as $record) {
            $lastPulseReceived = new Carbon($record->last_pulse_received_at);
            $monitoringEvent = MonitoringEventData::create(EventOriginator::Pulse(), [
                'connect'     => $record->hostname,
                'type'        => 'Pulse Lost',
                'description' => sprintf('Pulse lost for more than %d seconds.', $record->pulse_threshold),
                'meta'        => [
                    'lastPulseReceived'      => $lastPulseReceived->diffForHumans(),
                    'lastPulseReceivedAtUtc' => $record->last_pulse_received_at,
                    'lastPulseReceivedFrom'  => $record->last_remote_address,
                    'hostDescription'        => $record->description,
                    'hostLocation'           => $record->location,
                ],
            ]);
            Pulse::whereId($record->id)->firstOrFail()->markAlerted($monitoringEvent->eventId);
            event(new Problem($record->user_id, $monitoringEvent));
        }
    }
}
