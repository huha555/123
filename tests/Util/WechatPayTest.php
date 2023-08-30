<?php


namespace WeChatPay\Tests\Util;


use Tests\TestCase;
use Wzb\WechatPay\Services\WechatService;

class WechatPayTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $this->assertTrue(true);
    }

    public function testCreate()
    {
        $res =  (new WechatService())->WeChatPaymentOrderQuery('123','111');
        dd($res);
    }

}

