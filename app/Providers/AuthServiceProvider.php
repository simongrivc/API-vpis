<?php

namespace App\Providers;

use App\User;
use App\Uporabnik;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Crypt;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $request = app('request');

        // ALLOW OPTIONS METHOD
        if($request->getMethod() === 'OPTIONS')  {
            app()->options($request->path(), function () {
                return response('OK',200)
                    ->header('Access-Control-Allow-Origin', '*')
                    ->header('Access-Control-Allow-Methods','OPTIONS, GET, POST, PUT, DELETE')
                    ->header('Access-Control-Allow-Headers', 'Content-Type, Origin');                    
            });
        }
    }

    /**
     * Boot the authentication services for the application.
     *
     * @return void
     */
    public function boot()
    {
        // Here you may define how you wish users to be authenticated for your Lumen
        // application. The callback which receives the incoming request instance
        // should return either a User instance or null. You're free to obtain
        // the User instance via an API token or any other method necessary.

        $this->app['auth']->viaRequest('api', function ($request) {
            $header = $request->header('Api-Token');

            if($header)
            {
                //preveri če je token enak tokenu uporabnika v bazi, preveri še njegovo veljavnost
                //preveri kateri role ima user ter mu glede na role dovoli dostop do kontrolerja
                $uporabnik = User::where('api_token', '=', $header)->first();
                if($uporabnik)
                {
                    if($uporabnik->is_active)
                    {
                         $decrypted = Crypt::decrypt($uporabnik->api_token);
                         $podatkiToken = explode(";", $decrypted);
                         if($podatkiToken[3]>time())
                            return $uporabnik;
                         else
                            return response()->json(array('error' => 'token_expired'),401);
                    }
                    else 
                        return response()->json(array('error' => 'user_not_activated'),401);
                }
            }
            return null;
        });
    }
}
