<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Paginator::useBootstrapFive();

        View::composer(['front.*', 'layouts.front'], function ($view) {
            if (Schema::hasTable('settings')) {
                $view->with('siteName', Setting::get('site_name', 'جامعة النور'));
                $view->with('siteTagline', Setting::get('site_tagline', 'التعليم · البحث · خدمة المجتمع'));
            } else {
                $view->with('siteName', 'جامعة النور');
                $view->with('siteTagline', 'التعليم · البحث · خدمة المجتمع');
            }
        });
    }
}
