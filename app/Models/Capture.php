<?php

namespace App\Models;

use App\Data\Omc\CaptureData;
use App\Enums\CaptureStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

/**
 * @mixin IdeHelperCapture
 */
class Capture extends Model
{
    use HasFactory;

    protected $casts = [
        'last_errors'   => 'array',
        'last_warnings' => 'array',
        'last_alerts'   => 'array',
    ];

    public static function store(CaptureData $captureData): void
    {
        $errors = json_encode($captureData->errors);
        $warnings = json_encode($captureData->warnings);
        $alerts = json_encode($captureData->alerts);
        $measurements = json_encode($captureData->measurements);
        DB::insert(
            "INSERT INTO captures (
                        user_id,
                        hostname,
                        capture_id,
                        measurements,
                        last_submission_at,
                        last_user_agent,
                        last_remote_address,
                        last_content_length,
                        last_num_measurements,
                        last_warnings,
                        last_alerts,
                        num_submissions,
                        status,
                        created_at)
                    VALUES (
                        :userId,
                        :hostname,
                        :captureId,
                        :measurements,
                        NOW(),
                        :userAgent,
                        :remoteAddress,
                        :contentLength,
                        :numMeasurements,
                        :warnings,
                        :alerts,
                        1,
                        :status,
                        NOW())
                    ON DUPLICATE KEY UPDATE
                        measurements = :_measurements,
                        last_submission_at = NOW(),
                        last_user_agent = :_userAgent,
                        last_remote_address = :_remoteAddress,
                        last_content_length = :_contentLength,
                        last_num_measurements = :_numMeasurements,
                        last_warnings = :_warnings,
                        last_alerts = :_alerts,
                        num_submissions = num_submissions+1
                        ",
            [
                'userId'           => $captureData->userId,
                'hostname'         => $captureData->hostname,
                'captureId'        => $captureData->captureId,
                'status'           => CaptureStatus::Alive(),
                'measurements'     => $measurements,
                '_measurements'    => $measurements,
                'userAgent'        => $captureData->userAgent,
                '_userAgent'       => $captureData->userAgent,
                'remoteAddress'    => $captureData->remoteAddress,
                '_remoteAddress'   => $captureData->remoteAddress,
                'contentLength'    => $captureData->contentLength,
                '_contentLength'   => $captureData->contentLength,
                'numMeasurements'  => $captureData->numMeasurements,
                '_numMeasurements' => $captureData->numMeasurements,
                'warnings'         => $warnings,
                '_warnings'        => $warnings,
                'alerts'           => $alerts,
                '_alerts'          => $alerts,
            ]
        );
    }

    public function user(): BelongsTo|User
    {
        return $this->belongsTo(User::class);
    }
}
