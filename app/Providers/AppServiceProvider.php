<?php

namespace App\Providers;

use App\Http\Middleware\RoleMiddleware;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
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
        \Illuminate\Support\Facades\Route::aliasMiddleware('role', RoleMiddleware::class);

        VerifyEmail::toMailUsing(function (object $notifiable, string $url) {
            return (new MailMessage)
                ->subject('Verify Email Address')
                ->view('auth.email-verification-message',[
                'url'=>$url, 
                'logoSrc' => 'data:image/png;base64,' . base64_encode(file_get_contents(public_path('asset/image/logo.png'))),]);
        });
    }
   
}
