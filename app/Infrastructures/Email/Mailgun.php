<?php

namespace App\Infrastructures\Email;

use App\Infrastructures\Email\Contract\IEmailInfrastructure;
use Illuminate\Support\Facades\View;
use Mailgun\Mailgun as MailgunService;

class Mailgun implements IEmailInfrastructure
{
    protected MailgunService $mailgun;

    protected string $domain;

    public function __construct()
    {
        $this->mailgun = MailgunService::create(env('MAILGUN_SECRET'));
        $this->domain = env('MAILGUN_DOMAIN');
    }

    public function send($to, $subject, $view, $data, $type = 'local',
                         $toName = null, $from = null, $fromName = null,
                         $replyName = null, $reply = null, $attachment = null)
    {
        $content = View::make($view, $data)->render();

        $emailContent = [
            'from' => $fromName ? $fromName . ' <' . $from . '>' : $from,
            'to' => $toName ? $toName . ' <' . $to . '>' : $to,
            'subject' => $subject,
            'html' => $content
        ];

        if ($reply) {
            $emailContent['reply'] = $replyName ? $replyName . ' <' . $reply . '>' : $reply;
        }

        if ($attachment) {
            $emailContent['attachment'] = $attachment; // [['filePath' => $attachment, 'filename' => basename($attachment)]]
        }

        $this->mailgun->messages()->send($this->domain, $emailContent);
    }
}
