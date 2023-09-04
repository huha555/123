<?php

namespace Tests\Unit;

use Tests\TestCase;
use Wzb\WechatLogin\Services\WechatLoginService;
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
        $res =  (new WechatService())->jsapi(123,'test','1','12333');
        dd($res);
    }

}
