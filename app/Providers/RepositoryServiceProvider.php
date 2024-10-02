<?php

namespace App\Providers;

use App\Repositories\ApplicationCategoryRepository;
use App\Repositories\ApplicationRepository;
use App\Repositories\AppointmentRepository;
use App\Repositories\ChannelRepository;
use App\Repositories\ContactRepository;
use App\Repositories\Contracts\IApplicationCategoryRepository;
use App\Repositories\Contracts\IApplicationRepository;
use App\Repositories\Contracts\IAppointmentRepository;
use App\Repositories\Contracts\IChannelRepository;
use App\Repositories\Contracts\IContactRepository;
use App\Repositories\Contracts\IInquiryCategoryRepository;
use App\Repositories\Contracts\IInquiryRepository;
use App\Repositories\Contracts\IMediaRepository;
use App\Repositories\Contracts\IOpsigoOauthAccessTokenRepository;
use App\Repositories\Contracts\IOrderRepository;
use App\Repositories\Contracts\IPostRepository;
use App\Repositories\Contracts\IPaymentRepository;
use App\Repositories\Contracts\IPriceRepository;
use App\Repositories\Contracts\IProductCategoryRepository;
use App\Repositories\Contracts\IProductRepository;
use App\Repositories\Contracts\IReservationCategoryRepository;
use App\Repositories\Contracts\IReservationRepository;
use App\Repositories\Contracts\ITourCategoryRepository;
use App\Repositories\Contracts\ITourRepository;
use App\Repositories\Contracts\ITypeRepository;
use App\Repositories\Contracts\IUserRepository;
use App\Repositories\Contracts\IVehicleCategoryRepository;
use App\Repositories\Contracts\IVisaCategoryRepository;
use App\Repositories\Contracts\IVisaPassportRepository;
use App\Repositories\InquiryCategoryRepository;
use App\Repositories\InquiryRepository;
use App\Repositories\MediaRepository;
use App\Repositories\OpsigoOauthAccessTokenRepository;
use App\Repositories\OrderRepository;
use App\Repositories\PostRepository;
use App\Repositories\PaymentRepository;
use App\Repositories\PriceRepository;
use App\Repositories\ProductCategoryRepository;
use App\Repositories\ProductRepository;
use App\Repositories\ReservationCategoryRepository;
use App\Repositories\ReservationRepository;
use App\Repositories\TourCategoryRepository;
use App\Repositories\TourRepository;
use App\Repositories\TypeRepository;
use App\Repositories\UserRepository;
use App\Repositories\VehicleCategoryRepository;
use App\Repositories\VisaCategoryRepository;
use App\Repositories\VisaPassportRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(IUserRepository::class, UserRepository::class);

        // Blog
        $this->app->bind(IPostRepository::class, PostRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
