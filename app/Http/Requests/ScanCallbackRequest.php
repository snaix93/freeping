<?php

namespace App\Http\Requests;

use App\Support\CallbackProcessor\Enums\JobType;
use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Exists;

class ScanCallbackRequest extends FormRequest
{
    public function rules()
    {
        return [
            'id'                             => [
                'required',
                'uuid',
                new Exists('batches', 'id'),
            ],
            'job_type'                       => [
                'required',
                new EnumValue(JobType::class),
            ],
            'date'                           => [
                'required', 'array',
            ],
            'date.timestamp'                 => [
                'required', 'int',
            ],
            'date.datetime'                  => [
                'required', 'date',
            ],
            'node_id'                        => [
                'required',
                'uuid',
                new Exists('nodes', 'id'),
            ],
            'job_duration_sec'               => [
                'int',
            ],
            'results'                        => [
                'required', 'array',
            ],
            'results.*.target'               => [
                'required', 'string',
            ],
            'results.*.error'                => [
                'nullable', 'string',
            ],
            'results.*.success'              => [
                'nullable', 'boolean',
            ],
            // NOTE: the "port" int is the key of the array.
            'results.*.ports'                => [
                'required', 'nullable', 'array',
            ],
            'results.*.ports.*.state'        => [
                'required', 'string',
            ],
            'results.*.ports.*.reason'       => [
                'required', 'string',
            ],
            'results.*.ports.*.num_failures' => [
                'required', 'int',
            ],
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        abort(422, 'Validation for scanner failed');
    }
}
