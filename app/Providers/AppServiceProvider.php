<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Pagination\Paginator;
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
    public function boot(): void
    {
        Paginator::useBootstrapFive();

        Blade::directive('mineClass', function ($expression) {
            return "<?php echo auth()->check() && ({$expression})->master_id === auth()->id() ? 'class=\"thing-mine\"' : ''; ?>";
        });

        Blade::directive('tabActive', function ($expression) {
            return "<?php echo request('tab') === {$expression} ? 'class=\"tab-active\"' : ''; ?>";
        });

        Blade::directive('placeStateClass', function ($expression) {
            return "<?php echo ({$expression})->repair ? 'class=\"place-repair\"' : (({$expression})->work ? 'class=\"place-work\"' : ''); ?>";
        });
    }
}
