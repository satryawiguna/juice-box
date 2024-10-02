<?php

namespace App\Infrastructures\Email;

use App\Infrastructures\Email\Contract\IEmailInfrastructure;
use ElasticEmail\Api\EmailsApi;
use ElasticEmail\Api\TemplatesApi;
use ElasticEmail\Configuration;
use ElasticEmail\Model\BodyPart;
use ElasticEmail\Model\EmailContent;
use ElasticEmail\Model\EmailTransactionalMessageData;
use ElasticEmail\Model\TransactionalRecipient;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\View;

class ElasticEmail implements IEmailInfrastructure
{
    protected Client $client;

    protected Configuration $config;

    public function __construct()
    {
        $this->client = new Client();

        $this->config = Configuration::getDefaultConfiguration()->setApiKey('X-ElasticEmail-ApiKey', env('EMAIL_ELASTIC_SECRET'));
    }

    public function send($to, $subject, $view, $data, $type = 'local',
                         $toName = null, $from = null, $fromName = null,
                         $replyName = null, $reply = null, $attachment = null)
    {
        $apiTemplateInstance = new TemplatesApi(new Client, $this->config);

        $attachment = $data['attachment'] ?? [];

        $content = '';

        if ($type === 'cloud') {
            $view = $apiTemplateInstance->templatesByNameGet($view);

            $content = parseCustomTags($view->getBody()[0]->getContent(), $data);
        } else if ($type === 'local') {
            $content = View::make($view, $data)->render();
        }

        $emailContent = [
            "body" => [
                new BodyPart([
                    "content_type" => "HTML",
                    "content" => $content
                ])
            ],
            "from" => $from,
            "subject" => $subject
        ];

        if ($fromName) {
            $emailContent['envelope_from'] = $fromName;
        }

        if ($attachment) {
            $emailContent['attach_files'] = $attachment; // [['filePath' => $attachment, 'filename' => basename($attachment)]]
        }

        $emailMessageData = new EmailTransactionalMessageData([
            "recipients" => new TransactionalRecipient([
                "to" => [$to]
            ]),
            "content" => new EmailContent($emailContent)
        ]);

        $apiEmailInstance = new EmailsApi(new Client, $this->config);

        $apiEmailInstance->emailsTransactionalPost($emailMessageData);
    }
}
