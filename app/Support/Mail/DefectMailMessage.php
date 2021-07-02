<?php

namespace App\Support\Mail;

class DefectMailMessage extends MailMessage
{
    public $level = 'defect';

    public function __construct()
    {
        parent::__construct();
        $this->from(config('mail.from.address'), 'Defect '.config('app.name'));
    }
}
