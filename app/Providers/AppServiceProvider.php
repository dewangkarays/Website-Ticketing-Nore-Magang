<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
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
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer(
            'sidebar', 'App\Http\ViewComposers\NotifComposer'
        );

        Blade::directive('angka', function ($money) {
            return "<?php echo number_format($money, 0, ',', '.'); ?>";
        });
    }
}
