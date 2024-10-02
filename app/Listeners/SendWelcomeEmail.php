<?php

namespace App\Listeners;

use App\Events\UserVerified;
use App\Infrastructures\Email\Contract\IEmailInfrastructure;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class SendWelcomeEmail implements ShouldQueue
{
    use InteractsWithQueue;

    protected readonly IEmailInfrastructure $_emailInfrastructure;

    /**
     * @param IEmailInfrastructure $emailInfrastructure
     */
    public function __construct(IEmailInfrastructure $emailInfrastructure)
    {
        $this->_emailInfrastructure = $emailInfrastructure;
    }

    /**
     * Handle the event.
     */
    public function handle(UserVerified $event): void
    {
        try {
            $data = [
                'title' => __('email.title.howdy_enjoy_post_your_blog'),
                'first_name' => $event->user->profile->first_name,
                'last_name' => $event->user->profile->last_name,
                'website_url' => env('BASE_APP_URL')
            ];

            $this->_emailInfrastructure->send(
                to: $event->user->email,
                subject: __('email.subject.welcome_join_to_juicebox', ['app_name' => env('APP_NAME')]),
                view: 'emails.user.welcome',
                data: $data,
                toName: $event->user->profile->first_name . ' ' . $event->user->profile->last_name,
                from: env('MAIL_FROM_ADDRESS'),
                fromName: env('MAIL_FROM_NAME')
            );
        } catch (Exception $ex) {
            Log::error(__('message.error.something_went_wrong') . ' → ' . $ex->getMessage(), getLoggingContext());
        }
    }
}
