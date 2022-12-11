<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Rules\UniqueUserName;
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
        \Validator::extend('unique_user_name', function ($attribute, $value, $parameters, $validator) {
            list($table, $column) = $parameters;
            return (new UniqueUserName($table, $column))->passes($attribute, $value);
        });
    }
}
