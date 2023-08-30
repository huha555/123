<?php


namespace Wzb\WechatPay\Services;


use Wzb\WechatPay\Services\WechatPayNotifyService;

class PayCallbackService
{
    public function callback()
    {
        /** 请填写以下配置信息 **/
        $publicKeyPath = getcwd() . '/cert/public_key.pem';    //微信支付公钥证书文件路径，可以到 https://www.dedemao.com/wx/wx_publickey_download.php 生成
        $apiKey = 'xxxxx';   //https://pay.weixin.qq.com 帐户中心-安全中心-API安全-APIv3密钥-设置密钥
        /** 配置结束 **/

        $wxPay = new WechatPayNotifyService($apiKey, $publicKeyPath);
        $result = $wxPay->validate();
        if($result===false){
            //验证签名失败
            exit('sign error');
        }
        $result = $wxPay->notify();
        if ($result === false) {
            exit('pay error');
        }
        if ($result['trade_state'] == 'SUCCESS') {
            //支付成功，完成你的逻辑
            //例如连接数据库，获取付款金额$result['amount']['total']，获取订单号$result['out_trade_no']修改数据库中的订单状态等;
            //订单总金额，单位为分：$result['amount']['total']
            //用户支付金额，单位为分：$result['amount']['payer_total']
            //商户订单号：$result['out_trade_no']
            //微信支付订单号：$result['transaction_id']
            //银行类型：$result['bank_type']
            //支付完成时间：$result['success_time'] 格式为YYYY-MM-DDTHH:mm:ss+TIMEZONE
            //用户标识：$result['payer']['openid']
            //交易状态：$result['trade_state']
            //具体详细请看微信文档：https://pay.weixin.qq.com/wiki/doc/apiv3/wxpay/pay/transactions/chapter3_11.shtml
            echo 'success';
        }
    }
}
