<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Daftar policy (bisa dikosongkan jika tidak pakai).
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Boot method untuk mendaftarkan Gate.
     */
    public function boot(): void
    {
        $this->registerPolicies(); // <- sekarang tidak akan error

        Gate::define('admin-only', function ($user) {
            return $user->level === 6;
        });
    }
}
