<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Task;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('task_status_create', function () {
            return Auth::user();
        });

        Gate::define('task_status_update', function () {
            return Auth::user();
        });

        Gate::define('task_status_destroy', function () {
            return Auth::user();
        });

        Gate::define('task_create', function () {
            return Auth::user();
        });

        Gate::define('task_update', function () {
            return Auth::user();
        });

        Gate::define('task_destroy', function (User $user, Task $task) {
            return $user->id === $task->author->id;
        });
    }
}
