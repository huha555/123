<?php

namespace Wzb\WechatPay\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Wzb\WechatPay\Services\WechatService;


class WechatController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    
    public function __construct(WechatService $services)
    {
        $this->services = $services;
    }

    /**
     * FunctionName: jsapi
     * Description: jsapi 下单
     * Author: wzb
     * @param AdvertisingRequest $request
     * @return array
     */
    public function detail()
    {
dd(222);
    }
}
