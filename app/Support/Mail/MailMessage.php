<?php

namespace App\Support\Mail;

use Illuminate\Support\HtmlString;

class MailMessage extends \Illuminate\Notifications\Messages\MailMessage
{
    public ?MarkdownTableBuilder $tableBuilder = null;

    public $ad = true;

    public function __construct()
    {
        $this
            ->from(config('mail.from.address'), 'Registration '.config('app.name'))
            ->salutation(
                new HtmlString('💡 Login to your <a href="'.route('pingers').'">dashboard</a> to manage your checks, create new ones or adjust your report settings.<br><br>Thank you for using '.config('app.name').'!')
            );
    }

    public function hideAd()
    {
        $this->ad = false;

        return $this;
    }

    public function addTable(MarkdownTableBuilder $builder)
    {
        $this->tableBuilder = $builder;

        return $this;
    }

    public function toArray()
    {
        $data = array_merge([
            'ad' => $this->ad,
        ], parent::toArray());

        if (! is_null($this->tableBuilder)) {
            return array_merge([
                'table' => $this->tableBuilder->render(),
            ], $data);
        }

        return $data;
    }
}
