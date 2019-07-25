<?php
namespace App\Providers;

use App\Extensions\Auth\EloquentUserProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Auth::provider('eloquent', function ($app, array $config) {
            $model = $app['config']['auth.providers.users.model'];
            return new EloquentUserProvider($app['hash'], $model);
        });

        \Laravel\Passport\Passport::routes(null, ['middleware' => 'tenancy.enforce']);

        $this->commands([
            \Laravel\Passport\Console\InstallCommand::class,
            \Laravel\Passport\Console\ClientCommand::class,
            \Laravel\Passport\Console\KeysCommand::class,
        ]);

        \Laravel\Passport\Passport::tokensExpireIn(\Carbon\Carbon::now()->addMinutes(10));
        \Laravel\Passport\Passport::refreshTokensExpireIn(\Carbon\Carbon::now()->addDays(1));
        //
    }
}
