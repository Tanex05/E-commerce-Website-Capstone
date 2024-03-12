<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use File;

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
        if ($this->app->environment('production')) {
            \URL::forceScheme('https');
        }
        // Ensure the required directories exist and have write permissions
        $paths = [
            'public/flashoutimage',
            'public/flashsaleimage',
            'public/uploads',
            'public/backgrounds',
        ];

        foreach ($paths as $path) {
            $directory = public_path($path);
            if (!File::exists($directory)) {
                File::makeDirectory($directory, 0755, true);
            } else {
                File::chmod($directory, 0755);
            }
        }

    }
}
