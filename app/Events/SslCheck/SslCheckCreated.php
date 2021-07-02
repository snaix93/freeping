<?php


namespace App\Events\SslCheck;


use App\Models\SslCheck;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SslCheckCreated
{
    use Dispatchable, SerializesModels;

    /**
     * @var SslCheck
     */
    public $sslCheck;

    public function __construct(SslCheck $sslCheck)
    {
        $this->sslCheck = $sslCheck;
    }
}
