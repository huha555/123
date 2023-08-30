<?php

return [


        'merchant_id' => env('WECHATPAY_MERCHANTID'),//商户号
        'merchant_certificate_serial' => env('WECHATPAY_MERCHANTCERTIFICATESERIAL'),// 「商户API证书」的「证书序列号」
        'merchant_private_key_file_path' => '',// 从本地文件中加载「商户API私钥」，「商户API私钥」会用来生成请求的签名
        'platform_certificate_file_path' => '',// 从本地文件中加载「微信支付平台证书」，用来验证微信支付应答的签名

        'mch_id' => env('MCHID'),//直连商户号
        'app_id' => env('APPID',123),//应用ID
        'pay_notify_url' => env('PAYNOTIFYURL'),//支付回调
        'refund_notify_url' => env('REFUNDNOTIFYURL'),//退款回调


];
