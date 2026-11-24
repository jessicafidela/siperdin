<?php

namespace App\Providers;

use App\Models\PerjalananDinas;
use App\Policies\PerjalananDinasPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Password::defaults(fn () => Password::min(12));

        Gate::policy(PerjalananDinas::class, PerjalananDinasPolicy::class);
    }
}
