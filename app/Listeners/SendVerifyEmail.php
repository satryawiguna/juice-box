<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use App\Infrastructures\Email\Contract\IEmailInfrastructure;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;

class SendVerifyEmail implements ShouldQueue
{
    use InteractsWithQueue;

    protected readonly IEmailInfrastructure $_emailInfrastructure;

    /**
     * Create the event listener.
     */
    public function __construct(IEmailInfrastructure $emailInfrastructure)
    {
        $this->_emailInfrastructure = $emailInfrastructure;
    }

    /**
     * Handle the event.
     */
    public function handle(UserRegistered $event): void
    {
        try {
            $data = [
                'title' => __('email.title.verify_your_email_address'),
                'first_name' => $event->user->profile->first_name,
                'last_name' => $event->user->profile->last_name,
                'email_verify_url' => env('BASE_APP_URL') . '/email/verify/?token=' . base64_encode($this->generateEmailVerifyUrl($event))
            ];

            $this->_emailInfrastructure->send(
                to: $event->user->email,
                subject: __('email.subject.email_verification', ['app_name' => env('APP_NAME')]),
                view: 'emails.user.verify',
                data: $data,
                toName: $event->user->profile->first_name . ' ' . $event->user->profile->last_name,
                from: env('MAIL_FROM_ADDRESS'),
                fromName: env('MAIL_FROM_NAME')
            );
        } catch (Exception $ex) {
            Log::error(__('message.error.something_went_wrong') . ' → ' . $ex->getMessage(), getLoggingContext());
        }
    }

    protected function generateEmailVerifyUrl($event)
    {
        return URL::temporarySignedRoute(
            'get.api.verify',
            now()->addMinutes(Config::get('auth.verification.expire', 60)),
            ['id' => $event->user->getKey()]
        );
    }
}
