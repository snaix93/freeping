<?php

namespace App\Http\Requests;

use App\Rules\NotArrayRule;
use App\Rules\NotListRule;
use App\Rules\RequireMeasurementRule;

class CaptureRequest extends OmcRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        if ('json' === $this->getContentType()) {
            return $this->jsonValidationRules();
        }

        return $this->formValidationrules();
    }

    private function formValidationrules()
    {
        return [
            '*'        => [new RequireMeasurementRule($this->except('id', 'hostname', 'warnings', 'alerts'))],
            'id'       => ['required', 'min:3', 'max:255', 'alpha-dash'],
            'hostname' => ['required', 'min:3', 'max:255'],
        ];
    }

    private function jsonValidationRules(): array
    {
        return [
            'id'             => ['required', 'min:3', 'max:255', 'alpha-dash'],
            'hostname'       => ['required', 'min:3', 'max:255'],
            'alerts'         => ['nullable', 'array'],
            'warnings'       => ['nullable', 'array'],
            'measurements'   => ['nullable', 'array', 'required', new NotListRule()],
            'measurements.*' => [new NotArrayRule()],
        ];
    }
}
