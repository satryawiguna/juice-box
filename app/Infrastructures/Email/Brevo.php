<?php

namespace App\Infrastructures\Email;

use App\Infrastructures\Email\Contract\IEmailInfrastructure;
use Brevo\Client\Api\TransactionalEmailsApi;
use Brevo\Client\Configuration;
use Brevo\Client\Model\SendSmtpEmail;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;

class Brevo implements IEmailInfrastructure
{
    protected Configuration $config;
    protected TransactionalEmailsApi $apiInstance;

    public function __construct()
    {
        $this->config = Configuration::getDefaultConfiguration()->setApiKey('api-key', env('BREVO_SECRET'));
//        $this->config = Configuration::getDefaultConfiguration()->setApiKey('partner-key', env('BREVO_SECRET'));
        $this->apiInstance = new TransactionalEmailsApi(
            new Client(),
            $this->config
        );
    }

    public function send($to, $subject, $view, $data, $type = 'local',
                         $toName = null, $from = null, $fromName = null,
                         $replyName = null, $reply = null, $attachment = null)
    {
        try {
            $content = View::make($view, $data)->render();

            $email = [
                'subject' => $subject,
                'sender' => ['name' => $fromName, 'email' => $from],
                'to' => [['name' => $toName, 'email' => $to]],
                'htmlContent' => $content
            ];

            if ($reply) {
                $email['replyTo'] = ['name' => $replyName ?? '', 'email' => $replyName];
            }

            $sendSmtpEmail = new SendSmtpEmail($email);

            $this->apiInstance->sendTransacEmail($sendSmtpEmail);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
        }
    }

}
