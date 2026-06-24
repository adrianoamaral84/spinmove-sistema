<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use App\Models\Notification;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;


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
 
public function boot(): void
{

    if (
        Schema::hasTable(
            'notifications'
        )
    ) {

        $topNotifications =

        Notification::with(
            'plano'
        )

        ->where(
            'lida',
            false
        )

        ->latest()

        ->take(10)

        ->get();

        $topCount =

        $topNotifications
        ->count();

        View::share(
            'topNotifications',
            $topNotifications
        );

        View::share(
            'topCount',
            $topCount
        );

    }

}






    
    protected function mapApiRoutes()
{
    Route::prefix('api')
        ->middleware('api')
        ->group(base_path('routes/api.php'));
}

}
