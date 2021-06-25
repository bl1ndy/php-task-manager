<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Task;
use App\Policies\TaskPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Task::class => TaskPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('task_status_create', function (): ?\App\Models\User {
            return Auth::user();
        });

        Gate::define('task_status_update', function (): ?\App\Models\User {
            return Auth::user();
        });

        Gate::define('task_status_destroy', function (): ?\App\Models\User {
            return Auth::user();
        });

        Gate::define('label_actions', function (): ?\App\Models\User {
            return Auth::user();
        });
    }
}
