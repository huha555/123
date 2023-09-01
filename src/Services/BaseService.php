<?php

namespace Wzb\WechatPay\Services;

use WeChatPay\Crypto\Rsa;

use GuzzleHttp\Exception\RequestException;
use WechatPay\GuzzleMiddleware\WechatPayMiddleware;
use WechatPay\GuzzleMiddleware\Util\PemUtil;
use GuzzleHttp\HandlerStack;

class BaseService
{
    public function baseConfig()
    {
        // 商户号
        $merchantId = env('WECHAT_PAY_MERCHANT_ID');

        // 从本地文件中加载「商户API私钥」，「商户API私钥」会用来生成请求的签名
        $merchantPrivateKeyFilePath = env('MERCHANT_PRIVATE_KEY_FILE_PATH');
        $merchantPrivateKeyInstance = Rsa::from($merchantPrivateKeyFilePath, Rsa::KEY_TYPE_PRIVATE);

        // 「商户API证书」的「证书序列号」
        $merchantCertificateSerial = env('WECHAT_PAY_MERCHANT_CERTIFICATE_SERIAL');

        // 从本地文件中加载「微信支付平台证书」，用来验证微信支付应答的签名
        $platformCertificateFilePath = env('PLATFORM_CERTIFICATE_FILE_PATH');
        $platformPublicKeyInstance = Rsa::from($platformCertificateFilePath, Rsa::KEY_TYPE_PUBLIC);

        // 从「微信支付平台证书」中获取「证书序列号」
        $platformCertificateSerial = PemUtil::parseCertificateSerialNo($platformCertificateFilePath);

        // 构造一个 APIv3 客户端实例
        $instance = Builder::factory([
            'mchid'      => $merchantId,
            'serial'     => $merchantCertificateSerial,
            'privateKey' => $merchantPrivateKeyInstance,
            'certs'      => [
                $platformCertificateSerial => $platformPublicKeyInstance,
            ],
        ]);

        // 发送请求
//        $resp = $instance->chain('v3/certificates')->get(
//            ['debug' => true] // 调试模式，https://docs.guzzlephp.org/en/stable/request-options.html#debug
//        );

        return $instance;



        // 商户相关配置，
//        $merchantId = env('WECHATPAY_MERCHANTID'); // 商户号
//        $merchantSerialNumber = env('WECHATPAY_MERCHANTCERTIFICATESERIAL'); // 商户API证书序列号
//        $merchantPrivateKey = PemUtil::loadPrivateKey('./path/to/mch/private/key.pem'); // 商户私钥文件路径
//
//        // 微信支付平台配置
//        $wechatpayCertificate = PemUtil::loadCertificate('./path/to/wechatpay/cert.pem'); // 微信支付平台证书文件路径
//
//        // 构造一个WechatPayMiddleware
//        $wechatpayMiddleware = WechatPayMiddleware::builder()
//            ->withMerchant($merchantId, $merchantSerialNumber, $merchantPrivateKey) // 传入商户相关配置
//            ->withWechatPay([ $wechatpayCertificate ]) // 可传入多个微信支付平台证书，参数类型为array
//            ->build();
//
//        // 将WechatPayMiddleware添加到Guzzle的HandlerStack中
//        $stack = GuzzleHttp\HandlerStack::create();
//        $stack->push($wechatpayMiddleware, 'wechatpay');
//
//        // 创建Guzzle HTTP Client时，将HandlerStack传入，接下来，正常使用Guzzle发起API请求，WechatPayMiddleware会自动地处理签名和验签
//        $client = new GuzzleHttp\Client(['handler' => $stack]);
//
//        return $client;
    }
}
