<?php

namespace App\Infrastructures\Email\Contract;

interface IEmailInfrastructure
{
    public function send($to, $subject, $view, $data, $type = 'local',
                         $toName = null, $from = null, $fromName = null,
                         $replyName = null, $reply = null, $attachment = null);
}
