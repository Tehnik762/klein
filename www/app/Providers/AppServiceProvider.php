<?php

namespace App\Providers;

use App\Models\AdvertCategory;
use App\Models\Regions;
use App\Service\Sms\SmsSender;
use App\Service\Sms\TestSender;
use App\Service\Sms\VirtualSender;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(SmsSender::class, function(Application $app){
            
            $config = $app->make('config')->get('sms');
            
            switch ($config['driver']) {
                case "virtual":
                    return new VirtualSender();
                    break;
                case "test":
                    return new TestSender();
                    break;
            }         
        });

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrapFive();
        
        $flush = function() {
            Cache::flush();
        };

        AdvertCategory::created($flush);
        AdvertCategory::saved($flush);

    }
}
