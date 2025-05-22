<?php

namespace App\Providers;

use App\Models\SmtpSetting;
use App\Models\DepositAppeal;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
        
     public function boot()
     {
         // Other boot code...
         
         // Share pending appeals count with admin views
         View::composer('admin.admin_master', function ($view) {
             $pendingAppealsCount = DepositAppeal::where('status', 'pending')->count();
             $view->with('pendingAppealsCount', $pendingAppealsCount);
         });
     }
     
}
