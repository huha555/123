<?php


namespace Wzb\WechatPay\Services;


class WechatService extends BaseService
{
    protected $instance;

    public function __construct()
    {
        $this->instance = $this->baseConfig();
    }

    /**
     * FunctionName：curl
     * User: wzb
     * @param $url 请求地址
     * @param $jsonData 请求参数
     * @param $headers 请求头
     * @return mixed
     */
    private function curl($url,$jsonData,$headers)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }

    /**
     * FunctionName：jsapi
     * Description：jsapi 下单
     * User: wzb
     * @param $url 请求地址
     * @param $jsonData 请求参数
     * @param $headers 请求头
     * @return mixed
     */
    public function jsapi()
    {
        try {
            $resp = $this->instance
                ->chain('v3/pay/transactions/jsapi')
                ->post(['json' => [
                    'mchid'        => config('pay.mch_id'),//直连商户号
                    'appid'        => config('pay.app_id'),//应用ID
                    'out_trade_no' => 'native12177525012014070332333',//商户订单号
                    'description'  => 'Image形象店-深圳腾大-QQ公仔',//商品描述
                    'notify_url'   => 'https://weixin.qq.com/',//通知地址
                    'amount'       => [
                        'total'    => 1,
                        'currency' => 'CNY'
                    ],
                    'payer'       => [
                        'openid'    => 1
                    ],
                ]]);


//            // 对待签名字符串进行 SHA256 with RSA 签名
//            openssl_sign($signString, $signature, $privateKey, OPENSSL_ALGO_SHA256);
//
//            // 对签名结果进行 Base64 编码
//            $base64Signature = base64_encode($signature);



            echo $resp->getStatusCode(), PHP_EOL;
            echo $resp->getBody(), PHP_EOL;
        } catch (\Exception $e) {
            // 进行错误处理
            echo $e->getMessage(), PHP_EOL;
            if ($e instanceof \GuzzleHttp\Exception\RequestException && $e->hasResponse()) {
                $r = $e->getResponse();
                echo $r->getStatusCode() . ' ' . $r->getReasonPhrase(), PHP_EOL;
                echo $r->getBody(), PHP_EOL, PHP_EOL, PHP_EOL;
            }
            echo $e->getTraceAsString(), PHP_EOL;
        }
    }

    /**
     * FunctionName：WeChatPaymentOrderQuery
     * Description：微信支付订单号查询
     * User: wzb
     * @param $mchid 直连商户号
     * @param $transaction_id 微信支付订单号
     * @return mixed
     */
    public function WeChatPaymentOrderQuery($mchid,$transaction_id)
    {
        try {
            $resp = $this->instance
                ->v3->pay->transactions->id->_transaction_id_
                ->getAsync([
                    'query' => [
                        'mchid'     => config('pay.mch_id')//直连商户号
                    ],
                    'transaction_id' => $transaction_id,//微信支付订单号
                ]);

            echo $resp->getStatusCode(), PHP_EOL;
            echo $resp->getBody(), PHP_EOL;
        } catch (\Exception $e) {
            // 进行错误处理
            echo $e->getMessage(), PHP_EOL;
            if ($e instanceof \GuzzleHttp\Exception\RequestException && $e->hasResponse()) {
                $r = $e->getResponse();
                echo $r->getStatusCode() . ' ' . $r->getReasonPhrase(), PHP_EOL;
                echo $r->getBody(), PHP_EOL, PHP_EOL, PHP_EOL;
            }
            echo $e->getTraceAsString(), PHP_EOL;
        }
    }

    /**
     * FunctionName：MerchantOrderQuery
     * Description：商户订单号查询
     * User: wzb
     * @param $mchid 直连商户号
     * @param $out_trade_no 商户订单号
     * @return mixed
     */
    public function MerchantOrderQuery($mchid,$out_trade_no)
    {
        try {
            $resp = $this->instance
                ->v3->pay->transactions->outTradeNo->_out_trade_no_
                ->getAsync([
                    'query' => [
                        'mchid'   => config('pay.mch_id')//直连商户号
                    ],
                    'out_trade_no' => $out_trade_no,//商户订单号
                ]);

            echo $resp->getStatusCode(), PHP_EOL;
            echo $resp->getBody(), PHP_EOL;
        } catch (\Exception $e) {
            // 进行错误处理
            echo $e->getMessage(), PHP_EOL;
            if ($e instanceof \GuzzleHttp\Exception\RequestException && $e->hasResponse()) {
                $r = $e->getResponse();
                echo $r->getStatusCode() . ' ' . $r->getReasonPhrase(), PHP_EOL;
                echo $r->getBody(), PHP_EOL, PHP_EOL, PHP_EOL;
            }
            echo $e->getTraceAsString(), PHP_EOL;
        }
    }

    /**
     * FunctionName：OrderClose
     * Description：关闭订单
     * User: wzb
     * @param $mchid 直连商户号
     * @param $out_trade_no 商户订单号
     * @return mixed
     */
    public function OrderClose($mchid,$out_trade_no)
    {
        try {
            $resp = $this->instance
                ->v3->pay->transactions->outTradeNo->_out_trade_no_->close
                ->postAsync([
                    // 请求消息
                    'json' => [
                        'mchid'  => config('pay.mch_id')//直连商户号
                    ],
                    'out_trade_no' => $out_trade_no,//商户订单号
                ]);

            echo $resp->getStatusCode(), PHP_EOL;
            echo $resp->getBody(), PHP_EOL;
        } catch (\Exception $e) {
            // 进行错误处理
            echo $e->getMessage(), PHP_EOL;
            if ($e instanceof \GuzzleHttp\Exception\RequestException && $e->hasResponse()) {
                $r = $e->getResponse();
                echo $r->getStatusCode() . ' ' . $r->getReasonPhrase(), PHP_EOL;
                echo $r->getBody(), PHP_EOL, PHP_EOL, PHP_EOL;
            }
            echo $e->getTraceAsString(), PHP_EOL;
        }
    }


    /**
     * FunctionName：OrderRefund
     * Description：订单退款
     * User: wzb
     * @param $mchid 直连商户号
     * @param $out_trade_no 商户订单号
     * @return mixed
     */
    public function OrderRefund()
    {
        try {
            $resp = $this->instance
                ->chain('v3/refund/domestic/refunds')
                ->post(['json' => [
                    'transaction_id'        => '1900006XXX',//微信支付订单号 与 商户订单号 二选一
                    'out_trade_no' => 'native12177525012014070332333',//商户订单号
                    'out_refund_no'        => 'wxdace645e0bc2cXXX',//商户退款单号
                    'reason'  => 'Image形象店-深圳腾大-QQ公仔',//退款原因 非必填
                    'notify_url'   => 'https://weixin.qq.com/',//退款结果回调url
                    'amount'       => [
                        'refund'    => 1,//退款金额
                        'total'    => 1,//原订单金额
                        'currency' => 'CNY'//退款币种
                    ],
                    'goods_detail'       => [//指定商品退款需要传此参数，其他场景无需传递
                        'merchant_goods_id'    => 1,//商户侧商品编码
                        'goods_name'    => 1,//商品名称
                        'unit_price'    => 1,//商品单价
                        'refund_amount'    => 1,//商品退款金额
                        'refund_quantity'    => 1//商品退货数量
                    ]
                ]]);

            echo $resp->getStatusCode(), PHP_EOL;
            echo $resp->getBody(), PHP_EOL;
        } catch (\Exception $e) {
            // 进行错误处理
            echo $e->getMessage(), PHP_EOL;
            if ($e instanceof \GuzzleHttp\Exception\RequestException && $e->hasResponse()) {
                $r = $e->getResponse();
                echo $r->getStatusCode() . ' ' . $r->getReasonPhrase(), PHP_EOL;
                echo $r->getBody(), PHP_EOL, PHP_EOL, PHP_EOL;
            }
            echo $e->getTraceAsString(), PHP_EOL;
        }
    }


    /**
     * FunctionName：RefundQuery
     * Description：查询单笔退款
     * User: wzb
     * @param $out_refund_no 商户退款单号
     * @return mixed
     */
    public function RefundQuery($out_refund_no)
    {
        try {
            $resp = $this->instance
                ->v3->refunds->domestic->refunds->_out_refund_no_
                ->getAsync([
                    'out_refund_no' => $out_refund_no,//商户退款单号
                ]);
            echo $resp->getStatusCode(), PHP_EOL;
            echo $resp->getBody(), PHP_EOL;
        } catch (\Exception $e) {
            // 进行错误处理
            echo $e->getMessage(), PHP_EOL;
            if ($e instanceof \GuzzleHttp\Exception\RequestException && $e->hasResponse()) {
                $r = $e->getResponse();
                echo $r->getStatusCode() . ' ' . $r->getReasonPhrase(), PHP_EOL;
                echo $r->getBody(), PHP_EOL, PHP_EOL, PHP_EOL;
            }
            echo $e->getTraceAsString(), PHP_EOL;
        }
    }


    /**
     * FunctionName：ApplyBilling
     * Description：申请交易账单
     * User: wzb
     * @param $out_refund_no 商户退款单号
     * @return mixed
     */
    public function ApplyBilling()
    {
        try {
            $resp = $this->instance
                ->chain('v3/bill/tradebill')
                ->get(['json' => [
                    'bill_date' => '1900006XXX'//账单日期  格式yyyy-MM-dd仅支持三个月内的账单下载申请。
                ]]);

            echo $resp->getStatusCode(), PHP_EOL;
            echo $resp->getBody(), PHP_EOL;
        } catch (\Exception $e) {
            // 进行错误处理
            echo $e->getMessage(), PHP_EOL;
            if ($e instanceof \GuzzleHttp\Exception\RequestException && $e->hasResponse()) {
                $r = $e->getResponse();
                echo $r->getStatusCode() . ' ' . $r->getReasonPhrase(), PHP_EOL;
                echo $r->getBody(), PHP_EOL, PHP_EOL, PHP_EOL;
            }
            echo $e->getTraceAsString(), PHP_EOL;
        }
    }


    /**
     * FunctionName：ApplyForFundBill
     * Description：申请资金账单
     * User: wzb
     * @param $out_refund_no 商户退款单号
     * @return mixed
     */
    public function ApplyForFundBill()
    {
        try {
            $resp = $this->instance
                ->chain('v3/bill/fundflowbill')
                ->get(['json' => [
                    'bill_date' => '1900006XXX'//账单日期  格式yyyy-MM-dd仅支持三个月内的账单下载申请。
                ]]);

            echo $resp->getStatusCode(), PHP_EOL;
            echo $resp->getBody(), PHP_EOL;
        } catch (\Exception $e) {
            // 进行错误处理
            echo $e->getMessage(), PHP_EOL;
            if ($e instanceof \GuzzleHttp\Exception\RequestException && $e->hasResponse()) {
                $r = $e->getResponse();
                echo $r->getStatusCode() . ' ' . $r->getReasonPhrase(), PHP_EOL;
                echo $r->getBody(), PHP_EOL, PHP_EOL, PHP_EOL;
            }
            echo $e->getTraceAsString(), PHP_EOL;
        }
    }
    /**
     * FunctionName：DownloadBills
     * Description：下载账单
     * User: wzb
     * @param $out_refund_no 商户退款单号
     * @return mixed
     */
//    public function DownloadBills()
//    {
//        try {
//            $resp = $this->instance
//                ->chain('v3/bill/tradebill')
//                ->get(['json' => [
//                    'bill_date' => '1900006XXX'//账单日期  格式yyyy-MM-dd仅支持三个月内的账单下载申请。
//                ]]);
//
//            echo $resp->getStatusCode(), PHP_EOL;
//            echo $resp->getBody(), PHP_EOL;
//        } catch (\Exception $e) {
//            // 进行错误处理
//            echo $e->getMessage(), PHP_EOL;
//            if ($e instanceof \GuzzleHttp\Exception\RequestException && $e->hasResponse()) {
//                $r = $e->getResponse();
//                echo $r->getStatusCode() . ' ' . $r->getReasonPhrase(), PHP_EOL;
//                echo $r->getBody(), PHP_EOL, PHP_EOL, PHP_EOL;
//            }
//            echo $e->getTraceAsString(), PHP_EOL;
//        }
//    }
}
