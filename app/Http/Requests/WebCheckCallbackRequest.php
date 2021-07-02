<?php

namespace App\Http\Requests;

use App\Support\CallbackProcessor\Enums\JobType;
use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Exists;

class WebCheckCallbackRequest extends FormRequest
{
    public function rules()
    {
        return [
            'id'                           => [
                'required',
                'uuid',
                new Exists('batches', 'id'),
            ],
            'job_type'                     => [
                'required',
                new EnumValue(JobType::class),
            ],
            'date'                         => [
                'required', 'array',
            ],
            'date.timestamp'               => [
                'required', 'int',
            ],
            'date.datetime'                => [
                'required', 'date',
            ],
            'node_id'                      => [
                'required',
                'uuid',
                new Exists('nodes', 'id'),
            ],
            'job_duration_sec'             => [
                'int',
            ],
            'results'                      => [
                'required', 'array',
            ],
            'results.*.id'                 => [
                'required',
                'uuid',
                new Exists('web_checks', 'uuid'),
            ],
            'results.*.url'                => [
                'required', 'string', 'url',
            ],
            'results.*.total_time_spent_s' => [
                'required', 'numeric',
            ],
            'results.*.success'            => [
                'nullable', 'boolean',
            ],
            'results.*.error'              => [
                'nullable', 'string',
            ],
            'results.*.num_failures'       => [
                'required', 'int',
            ],
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        abort(422, 'Validation for web check failed');
    }
}
