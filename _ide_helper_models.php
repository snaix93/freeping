<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\Batch
 *
 * @property string      $id
 * @property string      $node_id
 * @property int         $checks_dispatched Number of checks sent to pinger node
 * @property int         $results_received  Number of check results received from check node
 * @property string|null $finished_at       datetime when a pinger nodes has sent back results
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Batch newModelQuery()
 * @method static Builder|Batch newQuery()
 * @method static Builder|Batch query()
 * @method static Builder|Batch whereChecksDispatched($value)
 * @method static Builder|Batch whereCreatedAt($value)
 * @method static Builder|Batch whereFinishedAt($value)
 * @method static Builder|Batch whereId($value)
 * @method static Builder|Batch whereNodeId($value)
 * @method static Builder|Batch whereResultsReceived($value)
 * @method static Builder|Batch whereUpdatedAt($value)
 * @mixin Eloquent
 * @method static Builder|Batch finished()
 * @mixin IdeHelperBatch
 */
	class IdeHelperBatch extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Capture
 *
 * @mixin IdeHelperCapture
 * @property int $id
 * @property int $user_id
 * @property string $hostname
 * @property string $capture_id
 * @property mixed $measurements
 * @property string $last_submission_at
 * @property int|null $num_submissions
 * @property string $last_user_agent
 * @property string $last_remote_address
 * @property int $last_content_length
 * @property int $last_num_measurements
 * @property array|null $last_alerts
 * @property array|null $last_warnings
 * @property mixed|null $last_defects
 * @property int|null $update_interval
 * @property int|null $status
 * @property string|null $dead_status_reported_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Capture newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Capture newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Capture query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Capture whereCaptureId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Capture whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Capture whereDeadStatusReportedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Capture whereHostname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Capture whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Capture whereLastAlerts($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Capture whereLastContentLength($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Capture whereLastDefects($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Capture whereLastNumMeasurements($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Capture whereLastRemoteAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Capture whereLastSubmissionAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Capture whereLastUserAgent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Capture whereLastWarnings($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Capture whereMeasurements($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Capture whereNumSubmissions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Capture whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Capture whereUpdateInterval($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Capture whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Capture whereUserId($value)
 */
	class IdeHelperCapture extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Node
 *
 * @property string      $id
 * @property string      $name
 * @property string      $request_token
 * @property string      $callback_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Node newModelQuery()
 * @method static Builder|Node newQuery()
 * @method static Builder|Node query()
 * @method static Builder|Node whereCallbackToken($value)
 * @method static Builder|Node whereCreatedAt($value)
 * @method static Builder|Node whereId($value)
 * @method static Builder|Node whereName($value)
 * @method static Builder|Node whereRequestToken($value)
 * @method static Builder|Node whereUpdatedAt($value)
 * @mixin Eloquent
 * @property string      $url
 * @method static Builder|Node whereUrl($value)
 * @property string      $short_name
 * @method static Builder|Node whereShortName($value)
 * @property string|null $country
 * @method static NodeFactory factory(...$parameters)
 * @method static Builder|Node whereCountry($value)
 * @mixin IdeHelperNode
 */
	class IdeHelperNode extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PingResult
 *
 * @property int                   $id
 * @property string                $connect
 * @property string                $node_id
 * @property PingResultStatus|null $status
 * @property string|null           $reason
 * @property Carbon|null           $created_at
 * @property Carbon|null           $updated_at
 * @property-read mixed            $ping_time
 * @property-read Node             $node
 * @method static PingResultCollection|static[] all($columns = ['*'])
 * @method static PingResultFactory factory(...$parameters)
 * @method static PingResultCollection|static[] get($columns = ['*'])
 * @method static Builder|PingResult newModelQuery()
 * @method static Builder|PingResult newQuery()
 * @method static Builder|PingResult query()
 * @method static Builder|PingResult whereConnect($value)
 * @method static Builder|PingResult whereCreatedAt($value)
 * @method static Builder|PingResult whereId($value)
 * @method static Builder|PingResult whereNodeId($value)
 * @method static Builder|PingResult whereReason($value)
 * @method static Builder|PingResult whereStatus($value)
 * @method static Builder|PingResult whereUpdatedAt($value)
 * @method static Builder|PingResult withOrderedNodes()
 * @mixin Eloquent
 * @mixin IdeHelperPingResult
 */
	class IdeHelperPingResult extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PingStats
 *
 * @mixin IdeHelperPingStats
 * @property int $id
 * @property string $connect
 * @property string $node_id
 * @property int $successes Counter of successful pings
 * @property int $failures Counter of unsuccessful pings
 * @property int $errors Counter of errors
 * @property string $datestamp
 * @property int $hour
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Node $node
 * @method static \Database\Factories\PingStatsFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PingStats newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PingStats newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PingStats query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PingStats whereConnect($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PingStats whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PingStats whereDatestamp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PingStats whereErrors($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PingStats whereFailures($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PingStats whereHour($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PingStats whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PingStats whereNodeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PingStats whereSuccesses($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PingStats whereUpdatedAt($value)
 */
	class IdeHelperPingStats extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Port
 *
 * @mixin IdeHelperPort
 * @property int $id
 * @property int $user_id
 * @property int $target_id
 * @property string $connect
 * @property int $port
 * @property \App\Enums\PortStatus $status
 * @property \Illuminate\Database\Eloquent\Casts\AsCollection|null $nodes_down
 * @property int $number_of_recoveries
 * @property \Illuminate\Support\Carbon|null $last_recovery_at
 * @property int $number_of_alerts
 * @property \Illuminate\Support\Carbon|null $last_alert_at
 * @property int $number_of_warnings
 * @property \Illuminate\Support\Carbon|null $last_warning_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Collections\ScanResultCollection|\App\Models\ScanResult[] $scanResults
 * @property-read int|null $scan_results_count
 * @property-read \App\Models\Target $target
 * @method static \Database\Factories\PortFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Port newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Port newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Port query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Port whereConnect($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Port whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Port whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Port whereLastAlertAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Port whereLastRecoveryAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Port whereLastWarningAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Port whereNodesDown($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Port whereNumberOfAlerts($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Port whereNumberOfRecoveries($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Port whereNumberOfWarnings($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Port wherePort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Port whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Port whereTargetId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Port whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Port whereUserId($value)
 */
	class IdeHelperPort extends \Eloquent implements \App\Models\Contracts\Checkable {}
}

namespace App\Models{
/**
 * App\Models\Problem
 *
 * @mixin IdeHelperProblem
 * @property int $id
 * @property int $user_id
 * @property string $event_id
 * @property string $originator
 * @property string $severity
 * @property string $connect
 * @property string|null $description
 * @property array|null $meta
 * @property array|null $check_definition
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Problem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Problem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Problem query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Problem whereCheckDefinition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Problem whereConnect($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Problem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Problem whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Problem whereEventId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Problem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Problem whereMeta($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Problem whereOriginator($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Problem whereSeverity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Problem whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Problem whereUserId($value)
 */
	class IdeHelperProblem extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Pulse
 *
 * @mixin IdeHelperPulse
 * @property int $id
 * @property int $user_id
 * @property string $hostname
 * @property string|null $description
 * @property string $location
 * @property \App\Enums\PulseStatus $status
 * @property string $last_user_agent
 * @property string $last_remote_address
 * @property \Illuminate\Support\Carbon|null $last_pulse_received_at
 * @property \Illuminate\Support\Carbon|null $alerted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $event_id
 * @property-read \App\Models\User $user
 * @method static \Database\Factories\PulseFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pulse newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pulse newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pulse query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pulse whereAlertedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pulse whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pulse whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pulse whereEventId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pulse whereHostname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pulse whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pulse whereLastPulseReceivedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pulse whereLastRemoteAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pulse whereLastUserAgent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pulse whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pulse whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pulse whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pulse whereUserId($value)
 */
	class IdeHelperPulse extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Pushover
 *
 * @mixin IdeHelperPushover
 * @property int $id
 * @property int $user_id
 * @property string $type
 * @property bool $alerts
 * @property bool $warnings
 * @property bool $recoveries
 * @property \Spatie\SchemalessAttributes\SchemalessAttributes $meta
 * @property \Illuminate\Support\Carbon|null $verified_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Enums\PushoverPriority $priority
 * @property-read string|null $pushover_key
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pushover newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pushover newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pushover query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pushover whereAlerts($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pushover whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pushover whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pushover whereMeta($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pushover whereRecoveries($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pushover whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pushover whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pushover whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pushover whereVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pushover whereWarnings($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Recipient withMeta()
 */
	class IdeHelperPushover extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Recipient
 *
 * @mixin IdeHelperRecipient
 * @property int $id
 * @property int $user_id
 * @property string $type
 * @property bool $alerts
 * @property bool $warnings
 * @property bool $recoveries
 * @property \Spatie\SchemalessAttributes\SchemalessAttributes $meta
 * @property \Illuminate\Support\Carbon|null $verified_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\RecipientFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Recipient newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Recipient newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Recipient query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Recipient whereAlerts($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Recipient whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Recipient whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Recipient whereMeta($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Recipient whereRecoveries($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Recipient whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Recipient whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Recipient whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Recipient whereVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Recipient whereWarnings($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Recipient withMeta()
 */
	class IdeHelperRecipient extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ScanResult
 *
 * @mixin IdeHelperScanResult
 * @property int $id
 * @property string $connect
 * @property int $port
 * @property string $node_id
 * @property \App\Enums\ScanResultStatus|null $status
 * @property string|null $reason
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $scan_time
 * @property-read \App\Models\Node $node
 * @method static \App\Models\Collections\ScanResultCollection|static[] all($columns = ['*'])
 * @method static \Database\Factories\ScanResultFactory factory(...$parameters)
 * @method static \App\Models\Collections\ScanResultCollection|static[] get($columns = ['*'])
 * @method static \App\Models\QueryBuilders\ScanResultQueryBuilder|\App\Models\ScanResult newModelQuery()
 * @method static \App\Models\QueryBuilders\ScanResultQueryBuilder|\App\Models\ScanResult newQuery()
 * @method static \App\Models\QueryBuilders\ScanResultQueryBuilder|\App\Models\ScanResult query()
 * @method static \App\Models\QueryBuilders\ScanResultQueryBuilder|\App\Models\ScanResult whereConnect($value)
 * @method static \App\Models\QueryBuilders\ScanResultQueryBuilder|\App\Models\ScanResult whereCreatedAt($value)
 * @method static \App\Models\QueryBuilders\ScanResultQueryBuilder|\App\Models\ScanResult whereId($value)
 * @method static \App\Models\QueryBuilders\ScanResultQueryBuilder|\App\Models\ScanResult whereNodeId($value)
 * @method static \App\Models\QueryBuilders\ScanResultQueryBuilder|\App\Models\ScanResult wherePort($value)
 * @method static \App\Models\QueryBuilders\ScanResultQueryBuilder|\App\Models\ScanResult whereReason($value)
 * @method static \App\Models\QueryBuilders\ScanResultQueryBuilder|\App\Models\ScanResult whereStatus($value)
 * @method static \App\Models\QueryBuilders\ScanResultQueryBuilder|\App\Models\ScanResult whereUpdatedAt($value)
 * @method static \App\Models\QueryBuilders\ScanResultQueryBuilder|\App\Models\ScanResult withOrderedNodes()
 */
	class IdeHelperScanResult extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ScanStats
 *
 * @mixin IdeHelperScanStats
 * @property int $id
 * @property string $connect
 * @property int $port
 * @property string $node_id
 * @property int $successes
 * @property int $failures
 * @property string $datestamp
 * @property int $hour
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Node $node
 * @method static \Database\Factories\ScanStatsFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ScanStats newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ScanStats newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ScanStats query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ScanStats whereConnect($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ScanStats whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ScanStats whereDatestamp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ScanStats whereFailures($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ScanStats whereHour($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ScanStats whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ScanStats whereNodeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ScanStats wherePort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ScanStats whereSuccesses($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ScanStats whereUpdatedAt($value)
 */
	class IdeHelperScanStats extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\SslCheck
 *
 * @mixin IdeHelperSslCheck
 * @property int $id
 * @property string $uuid
 * @property int $user_id
 * @property int $web_check_id
 * @property string $host
 * @property string|null $last_error_text
 * @property int $port
 * @property \App\Enums\SslCertificateStatus $certificate_status
 * @property \Illuminate\Support\Carbon|null $last_check_received_at
 * @property \Illuminate\Support\Carbon|null $alerted_at
 * @property \Illuminate\Support\Carbon|null $warned_at
 * @property \Illuminate\Support\Carbon|null $certificate_expires_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @property-read \App\Models\SslCheck $webCheck
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SslCheck newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SslCheck newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SslCheck query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SslCheck whereAlertedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SslCheck whereCertificateExpiresAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SslCheck whereCertificateStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SslCheck whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SslCheck whereHost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SslCheck whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SslCheck whereLastCheckReceivedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SslCheck whereLastErrorText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SslCheck wherePort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SslCheck whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SslCheck whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SslCheck whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SslCheck whereWarnedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SslCheck whereWebCheckId($value)
 */
	class IdeHelperSslCheck extends \Eloquent implements \App\Models\Contracts\Checkable {}
}

namespace App\Models{
/**
 * App\Models\Target
 *
 * @mixin IdeHelperTarget
 * @property int $id
 * @property int $user_id
 * @property string $connect
 * @property \App\Enums\TargetStatus $status
 * @property \Illuminate\Database\Eloquent\Casts\AsCollection|null $nodes_down
 * @property int $number_of_recovery_emails_sent
 * @property \Illuminate\Support\Carbon|null $last_recovery_sent_at
 * @property int $number_of_alert_emails_sent
 * @property \Illuminate\Support\Carbon|null $last_alert_sent_at
 * @property int $number_of_warning_emails_sent
 * @property \Illuminate\Support\Carbon|null $last_warning_sent_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Collections\PingResultCollection|\App\Models\PingResult[] $pingResults
 * @property-read int|null $ping_results_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\PingStats[] $pingStats
 * @property-read int|null $ping_stats_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Port[] $ports
 * @property-read int|null $ports_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ScanStats[] $scanStats
 * @property-read int|null $scan_stats_count
 * @property-read \App\Models\User $user
 * @method static \App\Models\QueryBuilders\TargetQueryBuilder|\App\Models\Target alive()
 * @method static \Database\Factories\TargetFactory factory(...$parameters)
 * @method static \App\Models\QueryBuilders\TargetQueryBuilder|\App\Models\Target newModelQuery()
 * @method static \App\Models\QueryBuilders\TargetQueryBuilder|\App\Models\Target newQuery()
 * @method static \App\Models\QueryBuilders\TargetQueryBuilder|\App\Models\Target query()
 * @method static \App\Models\QueryBuilders\TargetQueryBuilder|\App\Models\Target whereConnect($value)
 * @method static \App\Models\QueryBuilders\TargetQueryBuilder|\App\Models\Target whereCreatedAt($value)
 * @method static \App\Models\QueryBuilders\TargetQueryBuilder|\App\Models\Target whereId($value)
 * @method static \App\Models\QueryBuilders\TargetQueryBuilder|\App\Models\Target whereLastAlertSentAt($value)
 * @method static \App\Models\QueryBuilders\TargetQueryBuilder|\App\Models\Target whereLastRecoverySentAt($value)
 * @method static \App\Models\QueryBuilders\TargetQueryBuilder|\App\Models\Target whereLastWarningSentAt($value)
 * @method static \App\Models\QueryBuilders\TargetQueryBuilder|\App\Models\Target whereNodesDown($value)
 * @method static \App\Models\QueryBuilders\TargetQueryBuilder|\App\Models\Target whereNumberOfAlertEmailsSent($value)
 * @method static \App\Models\QueryBuilders\TargetQueryBuilder|\App\Models\Target whereNumberOfRecoveryEmailsSent($value)
 * @method static \App\Models\QueryBuilders\TargetQueryBuilder|\App\Models\Target whereNumberOfWarningEmailsSent($value)
 * @method static \App\Models\QueryBuilders\TargetQueryBuilder|\App\Models\Target whereStatus($value)
 * @method static \App\Models\QueryBuilders\TargetQueryBuilder|\App\Models\Target whereUpdatedAt($value)
 * @method static \App\Models\QueryBuilders\TargetQueryBuilder|\App\Models\Target whereUserId($value)
 */
	class IdeHelperTarget extends \Eloquent implements \App\Models\Contracts\Checkable {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @mixin IdeHelperUser
 * @property int $id
 * @property string|null $name
 * @property string $email
 * @property string|null $password
 * @property string|null $two_factor_secret
 * @property string|null $two_factor_recovery_codes
 * @property string $report_time_utc
 * @property string $report_time
 * @property string $report_timezone
 * @property string $report_offset
 * @property string|null $country_code
 * @property mixed|null $user_data
 * @property array|null $registration_track
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string|null $profile_photo_path
 * @property int|null $current_team_id
 * @property string|null $remember_token
 * @property string $omc_token
 * @property int $pulse_threshold
 * @property int $ssl_alert_threshold
 * @property int $ssl_warning_threshold
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string $profile_photo_url
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Problem[] $problems
 * @property-read int|null $problems_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Pulse[] $pulses
 * @property-read int|null $pulses_count
 * @property-read \App\Models\Pushover $pushoverRecipient
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Recipient[] $recipients
 * @property-read int|null $recipients_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\SslCheck[] $sslChecks
 * @property-read int|null $ssl_checks_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Target[] $targets
 * @property-read int|null $targets_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Sanctum\PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\WebCheck[] $webChecks
 * @property-read int|null $web_checks_count
 * @method static \App\Models\QueryBuilders\UserQueryBuilder|\App\Models\User didntJoinToday()
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static \App\Models\QueryBuilders\UserQueryBuilder|\App\Models\User newModelQuery()
 * @method static \App\Models\QueryBuilders\UserQueryBuilder|\App\Models\User newQuery()
 * @method static \App\Models\QueryBuilders\UserQueryBuilder|\App\Models\User query()
 * @method static \App\Models\QueryBuilders\UserQueryBuilder|\App\Models\User verified()
 * @method static \App\Models\QueryBuilders\UserQueryBuilder|\App\Models\User whereCountryCode($value)
 * @method static \App\Models\QueryBuilders\UserQueryBuilder|\App\Models\User whereCreatedAt($value)
 * @method static \App\Models\QueryBuilders\UserQueryBuilder|\App\Models\User whereCurrentTeamId($value)
 * @method static \App\Models\QueryBuilders\UserQueryBuilder|\App\Models\User whereEmail($value)
 * @method static \App\Models\QueryBuilders\UserQueryBuilder|\App\Models\User whereEmailVerifiedAt($value)
 * @method static \App\Models\QueryBuilders\UserQueryBuilder|\App\Models\User whereId($value)
 * @method static \App\Models\QueryBuilders\UserQueryBuilder|\App\Models\User whereName($value)
 * @method static \App\Models\QueryBuilders\UserQueryBuilder|\App\Models\User whereOmcToken($value)
 * @method static \App\Models\QueryBuilders\UserQueryBuilder|\App\Models\User wherePassword($value)
 * @method static \App\Models\QueryBuilders\UserQueryBuilder|\App\Models\User whereProfilePhotoPath($value)
 * @method static \App\Models\QueryBuilders\UserQueryBuilder|\App\Models\User wherePulseThreshold($value)
 * @method static \App\Models\QueryBuilders\UserQueryBuilder|\App\Models\User whereRegistrationTrack($value)
 * @method static \App\Models\QueryBuilders\UserQueryBuilder|\App\Models\User whereRememberToken($value)
 * @method static \App\Models\QueryBuilders\UserQueryBuilder|\App\Models\User whereReportOffset($value)
 * @method static \App\Models\QueryBuilders\UserQueryBuilder|\App\Models\User whereReportTime($value)
 * @method static \App\Models\QueryBuilders\UserQueryBuilder|\App\Models\User whereReportTimeUtc($value)
 * @method static \App\Models\QueryBuilders\UserQueryBuilder|\App\Models\User whereReportTimezone($value)
 * @method static \App\Models\QueryBuilders\UserQueryBuilder|\App\Models\User whereSslAlertThreshold($value)
 * @method static \App\Models\QueryBuilders\UserQueryBuilder|\App\Models\User whereSslWarningThreshold($value)
 * @method static \App\Models\QueryBuilders\UserQueryBuilder|\App\Models\User whereTwoFactorRecoveryCodes($value)
 * @method static \App\Models\QueryBuilders\UserQueryBuilder|\App\Models\User whereTwoFactorSecret($value)
 * @method static \App\Models\QueryBuilders\UserQueryBuilder|\App\Models\User whereUpdatedAt($value)
 * @method static \App\Models\QueryBuilders\UserQueryBuilder|\App\Models\User whereUserData($value)
 */
	class IdeHelperUser extends \Eloquent implements \Illuminate\Contracts\Auth\MustVerifyEmail, \YlsIdeas\SubscribableNotifications\Contracts\CanUnsubscribe, \YlsIdeas\SubscribableNotifications\Contracts\CheckSubscriptionStatusBeforeSendingNotifications {}
}

namespace App\Models{
/**
 * App\Models\WebCheck
 *
 * @mixin IdeHelperWebCheck
 * @property int $id
 * @property string $uuid
 * @property int $user_id
 * @property string $url
 * @property string $protocol
 * @property string $host
 * @property int|null $port
 * @property string|null $path
 * @property string|null $query
 * @property string|null $fragment
 * @property string $method
 * @property int $expected_http_status
 * @property bool|null $search_html_source
 * @property string|null $expected_pattern
 * @property \Illuminate\Database\Eloquent\Casts\AsArrayObject|null $headers
 * @property \App\Enums\WebCheckStatus $status
 * @property \Illuminate\Database\Eloquent\Casts\AsCollection|null $nodes_down
 * @property int $number_of_recoveries
 * @property \Illuminate\Support\Carbon|null $last_recovery_at
 * @property int $number_of_alerts
 * @property \Illuminate\Support\Carbon|null $last_alert_at
 * @property int $number_of_warnings
 * @property \Illuminate\Support\Carbon|null $last_warning_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string $url_host
 * @property-read \App\Models\SslCheck|null $sslChecks
 * @property-read \App\Models\User $user
 * @property-read \App\Models\Collections\WebCheckResultCollection|\App\Models\WebCheckResult[] $webCheckResults
 * @property-read int|null $web_check_results_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\WebCheckStats[] $webCheckStats
 * @property-read int|null $web_check_stats_count
 * @method static \Database\Factories\WebCheckFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WebCheck newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WebCheck newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WebCheck query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WebCheck whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WebCheck whereExpectedHttpStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WebCheck whereExpectedPattern($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WebCheck whereFragment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WebCheck whereHeaders($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WebCheck whereHost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WebCheck whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WebCheck whereLastAlertAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WebCheck whereLastRecoveryAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WebCheck whereLastWarningAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WebCheck whereMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WebCheck whereNodesDown($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WebCheck whereNumberOfAlerts($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WebCheck whereNumberOfRecoveries($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WebCheck whereNumberOfWarnings($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WebCheck wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WebCheck wherePort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WebCheck whereProtocol($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WebCheck whereQuery($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WebCheck whereSearchHtmlSource($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WebCheck whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WebCheck whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WebCheck whereUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WebCheck whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WebCheck whereUuid($value)
 */
	class IdeHelperWebCheck extends \Eloquent implements \App\Models\Contracts\Checkable {}
}

namespace App\Models{
/**
 * App\Models\WebCheckResult
 *
 * @mixin IdeHelperWebCheckResult
 * @property int $id
 * @property string $uuid
 * @property string $node_id
 * @property \App\Enums\WebCheckResultStatus|null $status
 * @property string|null $reason
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $check_time
 * @property-read \App\Models\Node $node
 * @method static \App\Models\Collections\WebCheckResultCollection|static[] all($columns = ['*'])
 * @method static \App\Models\Collections\WebCheckResultCollection|static[] get($columns = ['*'])
 * @method static \App\Models\QueryBuilders\WebCheckResultQueryBuilder|\App\Models\WebCheckResult newModelQuery()
 * @method static \App\Models\QueryBuilders\WebCheckResultQueryBuilder|\App\Models\WebCheckResult newQuery()
 * @method static \App\Models\QueryBuilders\WebCheckResultQueryBuilder|\App\Models\WebCheckResult query()
 * @method static \App\Models\QueryBuilders\WebCheckResultQueryBuilder|\App\Models\WebCheckResult whereCreatedAt($value)
 * @method static \App\Models\QueryBuilders\WebCheckResultQueryBuilder|\App\Models\WebCheckResult whereId($value)
 * @method static \App\Models\QueryBuilders\WebCheckResultQueryBuilder|\App\Models\WebCheckResult whereNodeId($value)
 * @method static \App\Models\QueryBuilders\WebCheckResultQueryBuilder|\App\Models\WebCheckResult whereReason($value)
 * @method static \App\Models\QueryBuilders\WebCheckResultQueryBuilder|\App\Models\WebCheckResult whereStatus($value)
 * @method static \App\Models\QueryBuilders\WebCheckResultQueryBuilder|\App\Models\WebCheckResult whereUpdatedAt($value)
 * @method static \App\Models\QueryBuilders\WebCheckResultQueryBuilder|\App\Models\WebCheckResult whereUuid($value)
 * @method static \App\Models\QueryBuilders\WebCheckResultQueryBuilder|\App\Models\WebCheckResult withOrderedNodes()
 */
	class IdeHelperWebCheckResult extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\WebCheckStats
 *
 * @mixin IdeHelperWebCheckStats
 * @property int $id
 * @property string $uuid
 * @property string $node_id
 * @property int $successes
 * @property int $errors
 * @property string $datestamp
 * @property int $hour
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Node $node
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WebCheckStats newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WebCheckStats newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WebCheckStats query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WebCheckStats whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WebCheckStats whereDatestamp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WebCheckStats whereErrors($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WebCheckStats whereHour($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WebCheckStats whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WebCheckStats whereNodeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WebCheckStats whereSuccesses($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WebCheckStats whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WebCheckStats whereUuid($value)
 */
	class IdeHelperWebCheckStats extends \Eloquent {}
}

