<?php

namespace App\Providers;

use App\Events\ApplicationApproved;
use App\Events\ApplicationConfirmed;
use App\Events\ApplicationRejected;
use App\Events\FlightTicketCanceled;
use App\Events\FlightTicketIssued;
use App\Events\HotelVoucherCanceled;
use App\Events\HotelVoucherIssued;
use App\Events\UserRegistered;
use App\Events\UserVerified;
use App\Events\PaymentFail;
use App\Events\PaymentPending;
use App\Events\PaymentSuccess;
use App\Events\TrainTicketCanceled;
use App\Events\TrainTicketIssued;
use App\Events\VisaPassportDocumentCanceled;
use App\Events\VisaPassportDocumentIssued;
use App\Listeners\SendApplicationNotificationEmail;
use App\Listeners\SendDocumentNotificationEmail;
use App\Listeners\SendPaymentNotificationEmail;
use App\Listeners\SendTicketNotificationEmail;
use App\Listeners\SendVerifyEmail;
use App\Listeners\SendVoucherNotificationEmail;
use App\Listeners\SendWelcomeEmail;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        UserRegistered::class => [SendVerifyEmail::class],
        UserVerified::class => [SendWelcomeEmail::class],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        parent::boot();
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
