<?php

namespace App\Support\Mail;

class AlertMailMessage extends MailMessage
{
    public $level = 'alert';

    public function __construct()
    {
        parent::__construct();
        $this->from(config('mail.from.address'), 'Alert '.config('app.name'));
    }
}
