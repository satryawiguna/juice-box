<?php

namespace App\Providers;

use App\Infrastructures\Email\Brevo;
use App\Infrastructures\Email\Contract\IEmailInfrastructure;
use App\Infrastructures\Storage\Contract\IStorageInfrastructure as IStorageGDriveService;
use App\Infrastructures\Storage\Contract\IStorageInfrastructure as IStorageSpaceService;
use App\Infrastructures\Storage\GDrive;
use App\Infrastructures\Storage\Space;
use App\Services\ApplicationCategoryService;
use App\Services\ApplicationService;
use App\Services\AuthService;
use App\Services\ChannelService;
use App\Services\Contracts\IApplicationCategoryService;
use App\Services\Contracts\IApplicationService;
use App\Services\Contracts\IAuthService;
use App\Services\Contracts\IChannelService;
use App\Services\Contracts\ICountriesService;
use App\Services\Contracts\IFlightService;
use App\Services\Contracts\IHotelService;
use App\Services\Contracts\IInquiryCategoryService;
use App\Services\Contracts\IInquiryService;
use App\Services\Contracts\IMediaService;
use App\Services\Contracts\IMembershipService;
use App\Services\Contracts\IOpsigoAuthService;
use App\Services\Contracts\IOrderService;
use App\Services\Contracts\IPostService;
use App\Services\Contracts\IPaymentService;
use App\Services\Contracts\IPriceService;
use App\Services\Contracts\IProductCategoryService;
use App\Services\Contracts\IProductService;
use App\Services\Contracts\IReservationCategoryService;
use App\Services\Contracts\IReservationService;
use App\Services\Contracts\ITourCategoryService;
use App\Services\Contracts\ITourService;
use App\Services\Contracts\ITrainService;
use App\Services\Contracts\ITypeService;
use App\Services\Contracts\IUserService;
use App\Services\Contracts\IVehicleCategoryService;
use App\Services\Contracts\IVisaCategoryService;
use App\Services\Contracts\IVisaPassportService;
use App\Services\CountriesService;
use App\Services\FlightService;
use App\Services\HotelService;
use App\Services\InquiryCategoryService;
use App\Services\InquiryService;
use App\Services\MediaService;
use App\Services\MembershipService;
use App\Services\OpsigoAuthService;
use App\Services\OrderService;
use App\Services\PostService;
use App\Services\PaymentService;
use App\Services\PriceService;
use App\Services\ProductCategoryService;
use App\Services\ProductService;
use App\Services\ReservationCategoryService;
use App\Services\ReservationService;
use App\Services\TourCategoryService;
use App\Services\TourService;
use App\Services\TrainService;
use App\Services\TypeService;
use App\Services\UserService;
use App\Services\VehicleCategoryService;
use App\Services\VisaCategoryService;
use App\Services\VisaPassportService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(IUserService::class, UserService::class);

        // Blog
        $this->app->bind(IPostService::class, PostService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
