<?php

namespace App\Http\Requests;

class PulseRequest extends OmcRequest
{
    public function rules()
    {
        return [
            'hostname'    => [
                'required',
                'min:3',
                'max:255',
                'regex:/^(?!\-)(?:[a-zA-Z\d\-]{0,62}[a-zA-Z\d-]\.){0,126}(?!\d+)[a-zA-Z\d-]{0,63}$/i',
            ],
            'location'    => [
                'max:255',
            ],
            'description' => [
                'max:1024',
            ],
        ];
    }
}
