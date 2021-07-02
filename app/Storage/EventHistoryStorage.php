<?php

namespace App\Storage;

use App\Data\Events\MonitoringEventData;
use App\Support\Influx\FluxQuery;
use App\Support\Influx\FluxResults;
use Illuminate\Support\Facades\Log;
use InfluxDB2\Point;

class EventHistoryStorage extends InfluxStorage
{
    public function __construct(protected int $userId)
    {
        parent::__construct('eventHistory');
    }

    public function storeProblem(MonitoringEventData $monitoringEvent)
    {
        Log::debug('Storing Problem Event to Influx');
        $this->write(
            Point::measurement('problems')
                ->addTag('user_id', $this->userId)
                ->addTag('event_id', $monitoringEvent->eventId)
                ->addTag('connect', $monitoringEvent->connect)
                ->addTag('originator', $monitoringEvent->originator)
                ->addTag('severity', $monitoringEvent->severity)
                ->addField('description', $monitoringEvent->description)
                ->addField('meta', json_encode($monitoringEvent->meta))
                ->addField('checkDefinition', json_encode($monitoringEvent->checkDefinition))
        );
    }

    public function storeRecovery(MonitoringEventData $monitoringEvent)
    {
        Log::debug('Storing Recovery Event to Influx', ['EventId' => $monitoringEvent->eventId]);

        $this->write(
            Point::measurement('recoveries')
                ->addTag('user_id', $this->userId)
                ->addTag('event_id', $monitoringEvent->eventId)
                ->addField('meta', json_encode($monitoringEvent->meta))
                ->addField('checkDefinition', json_encode($monitoringEvent->checkDefinition))
        );
    }

    public function getEvents()
    {
        $problemQuery = FluxQuery::build($this->bucket, 'problems')
            ->whereTag('user_id', $this->userId)
            ->range('-24h')
            ->groupBy('user_id');
        $recoveriesQuery = FluxQuery::build($this->bucket, 'recoveries')
            ->whereTag('user_id', $this->userId)
            ->range('-24h')
            ->groupBy('user_id');

        $problems = FluxResults::fromQuery($this->read($problemQuery))->all();
        $recoveries = FluxResults::fromQuery($this->read($recoveriesQuery))->collect();

        $return = [];
        foreach ($problems as $problem) {
            $return[] = [
                'problem'  => $problem,
                'recovery' => $recoveries->where('event_id', $problem['event_id'])->first(),
            ];
        }

        return $return;
    }
}
