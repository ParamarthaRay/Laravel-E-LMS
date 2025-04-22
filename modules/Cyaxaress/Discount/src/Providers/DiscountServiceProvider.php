<?php

namespace Cyaxaress\Discount\Providers;

use Cyaxaress\Discount\Models\Discount;
use Cyaxaress\Discount\Policies\DiscountPolicy;
use Cyaxaress\RolePermissions\Models\Permission;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class DiscountServiceProvider extends ServiceProvider
{
    public $namespace = "Cyaxaress\Discount\Http\Controllers";

    public function register()
    {
        // Register event service provider
        $this->app->register(EventServiceProvider::class);

        // Define routes for the discount section
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(__DIR__.'/../Routes/discount_routes.php');

        // Load views, migrations, and translations for the discount section
        $this->loadViewsFrom(__DIR__.'/../Resources/Views/', 'Discounts');
        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations');
        $this->loadJsonTranslationsFrom(__DIR__.'/../Resources/Lang/');

        // Define a policy for the Discount model
        Gate::policy(Discount::class, DiscountPolicy::class);
    }

    public function boot()
    {
        // Set sidebar menu item for discounts
        config()->set('sidebar.items.discounts', [
            'icon' => 'i-discounts',
            'title' => 'Discounts',  // The title here is now in English
            'url' => route('discounts.index'),
            'permission' => Permission::PERMISSION_MANAGE_DISCOUNT,
        ]);
    }
}
