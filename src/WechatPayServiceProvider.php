<?php


namespace Wzb\WeChatPay;


use Illuminate\Support\ServiceProvider;

class WechatPayServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/pay.php' => config_path('pay.php'),
        ], 'config');
    }

    public function register()
    {

    }
}
