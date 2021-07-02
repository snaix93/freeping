<?php

namespace App\Support\Mail;

class WarningMailMessage extends MailMessage
{
    public $level = 'warning';

    public function __construct()
    {
        parent::__construct();
        $this->from(config('mail.from.address'), 'Warning '.config('app.name'));
    }
}
