<?php

namespace App\Support\Mail;

class RecoveredMailMessage extends MailMessage
{
    public $level = 'recovery';

    public function __construct()
    {
        parent::__construct();
        $this->from(config('mail.from.address'), 'Recovery '.config('app.name'));
    }
}
