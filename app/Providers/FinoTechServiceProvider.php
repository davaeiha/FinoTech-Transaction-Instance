<?php

namespace App\Providers;

use App\FinoTech\InquiryService;
use App\FinoTech\PaymentService;
use App\FinoTech\ReportService;
use Illuminate\Support\ServiceProvider;

class FinoTechServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('payment',function (){
            return new PaymentService();
        });

        $this->app->singleton('inquiry',function (){
            return new InquiryService();
        });

        $this->app->singleton('report',function (){
            return new ReportService();
        });
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
