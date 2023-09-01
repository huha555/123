<?php


namespace Wzb\WechatPay\Services;


use WeChatPay\Exception\InvalidArgumentException;

class WechatService extends BaseService
{
    protected $instance;

    public function __construct()
    {
//        $this->instance = $this->baseConfig();
    }

    /**
     * FunctionName：jsapi
     * Description：jsapi 下单
     * User: wzb
     * @param $out_trade_no 请求地址
     * @param $jsonData 请求参数
     * @param $headers 请求头
     * @return mixed
     */
    public function jsapi($out_trade_no, $description, $total, $openid)
    {
        if ($total <= 0) {
            throw new InvalidArgumentException('总金额必须大于0元');
        }
        try {
            $resp = $this->instance
                ->chain('v3/pay/transactions/jsapi')
                ->post(['json' => [
                    'mchid' => env('MCH_ID'),//直连商户号
                    'appid' => env('APP_ID'),//应用ID
                    'out_trade_no' => $out_trade_no,//商户订单号
                    'description' => $description,//商品描述
                    'notify_url' => env('PAY_NOTIFY_URL'),//通知地址
                    'amount' => [
                        'total' => $total, //总金额
                        'currency' => 'CNY'
                    ],
                    'payer' => [
                        'openid' => $openid
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
     * @param $transaction_id 微信支付订单号
     * @return mixed
     */
    public function WeChatPaymentOrderQuery($transaction_id)
    {
        try {
            $resp = $this->instance
                ->v3->pay->transactions->id->_transaction_id_
                ->getAsync([
                    'query' => [
                        'mchid' => env('MCH_ID')//直连商户号
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
    public function MerchantOrderQuery($mchid, $out_trade_no)
    {
        try {
            $resp = $this->instance
                ->v3->pay->transactions->outTradeNo->_out_trade_no_
                ->getAsync([
                    'query' => [
                        'mchid' => env('MCH_ID')//直连商户号
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
    public function OrderClose($mchid, $out_trade_no)
    {
        try {
            $resp = $this->instance
                ->v3->pay->transactions->outTradeNo->_out_trade_no_->close
                ->postAsync([
                    // 请求消息
                    'json' => [
                        'mchid' => env('MCH_ID')//直连商户号
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
                    'transaction_id' => '1900006XXX',//微信支付订单号 与 商户订单号 二选一
                    'out_trade_no' => 'native12177525012014070332333',//商户订单号
                    'out_refund_no' => 'wxdace645e0bc2cXXX',//商户退款单号
                    'reason' => 'Image形象店-深圳腾大-QQ公仔',//退款原因 非必填
                    'notify_url' => env('REFUND_NOTIFY_URL'),//退款结果回调url
                    'amount' => [
                        'refund' => 1,//退款金额
                        'total' => 1,//原订单金额
                        'currency' => 'CNY'//退款币种
                    ],
                    'goods_detail' => [//指定商品退款需要传此参数，其他场景无需传递
                        'merchant_goods_id' => 1,//商户侧商品编码
                        'goods_name' => 1,//商品名称
                        'unit_price' => 1,//商品单价
                        'refund_amount' => 1,//商品退款金额
                        'refund_quantity' => 1//商品退货数量
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









///////////////////////////////////////////////////////////////////////////////////////////////////////////////////




    /**
         * 微信支付统一下单
         * @$name 订单名称
         * @$ordernumber 订单单号（自己生成的）
         * @$money  金额
         * @$openid  用户微信的openid
        */
    public function wechartAddOrder($name, $ordernumber, $money, $openid)
    {
        $appid = env('WECHAT.appid'); // 微信APPID
        $mchid = env('WECHAT.mch_id'); // 商户号
        $xlid = env('WECHAT.serial_number');//API序列号

        $out_trade_no = order_id();//生成支付单号（和订单号不一样）这样做是保证同一个订单可以被多次进行支付，因为每次支付单号不一样
        $url = "https://api.mch.weixin.qq.com/v3/pay/transactions/jsapi";
        $urlarr = parse_url($url);
        $data = array();
        $randstr = getrandstr(16);//随机字符串长度不超过32（加密使用的）
        $time = time();
        $data['appid'] = $appid;
        $data['mchid'] = $mchid;
        $data['description'] = $name;//商品描述
        $data['attach'] = $ordernumber;//订单编号
        $data['out_trade_no'] = $out_trade_no;//支付订单编号
        $data['notify_url'] = "";//回调接口
        $data['amount']['total'] = $money;
        $data['payer']['openid'] = $openid;//用户付款的openID

        $data = json_encode($data); //转json串
        $key = $this->getSign($data, $urlarr['path'], $randstr, $time);//微信支付签名加密
        $token = sprintf('mchid="%s",serial_no="%s",nonce_str="%s",timestamp="%d",signature="%s"', $mchid, $xlid, $randstr, $time, $key);//头部信息
        $header = array(
            'Content-Type:' . 'application/json; charset=UTF-8',
            'Accept:application/json',
            'User-Agent:*/*',
            'Authorization: WECHATPAY2-SHA256-RSA2048 ' . $token
        );
        $ret = $this->curl_post_https($url, $data, $header); //发送请求进行预支付
        $ret = json_decode($ret, true);
        if (isset($ret['prepay_id'])) { //拉起预支付成功
            $res['timeStamp'] = $time;//时间戳
            $res['nonceStr'] = $randstr;//随机字符串
            $res['signType'] = 'RSA';//签名算法，暂支持 RSA
            $res['package'] = 'prepay_id=' . $ret['prepay_id'];//统一下单接口返回的 prepay_id 参数值，提交格式如：prepay_id=*
            $res['paySign'] = $this->getWechartSign($appid,$time,$res['nonceStr'],$res['package']);//签名
            return $res; //返回给前端需要的串
        }
        return $ret;
    }

    /**
     * 统一下单之后前端需要的微信支付所需签名
     * 微信支付签名
     */
    public function getSign($data = array(), $url, $randstr, $time)
    {
        $str = "POST" . "\n" . $url . "\n" . $time . "\n" . $randstr . "\n" . $data . "\n";
        $key = file_get_contents(root_path() . '/vendor/path/apiclient_key.pem');//在商户平台下载的秘钥
        $str = $this->getSha256WithRSA($str, $key);
        return $str;
    }

    /**
     * POST请求方法
     * PHP CURL HTTPS POST
     */
    public function curl_post_https($url, $data, $header)
    { // 模拟提交数据函数
        $curl = curl_init(); // 启动一个CURL会话
        curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2); // 从证书中检查SSL加密算法是否存在
        curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); // 模拟用户使用的浏览器
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转
        curl_setopt($curl, CURLOPT_AUTOREFERER, 1); // 自动设置Referer
        curl_setopt($curl, CURLOPT_POST, 1); // 发送一个常规的Post请求
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data); // Post提交的数据包
        curl_setopt($curl, CURLOPT_TIMEOUT, 30); // 设置超时限制防止死循环
        curl_setopt($curl, CURLOPT_HEADER, 0); // 显示返回的Header区域内容
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回

        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        $tmpInfo = curl_exec($curl); // 执行操作
        if (curl_errno($curl)) {
            echo 'Errno' . curl_error($curl);//捕抓异常
        }
        curl_close($curl); // 关闭CURL会话
        return $tmpInfo; // 返回数据，json格式
    }

    /**
     * 统一下单调起支付的签名
     */
    public function getWechartSign($appid, $timeStamp, $noncestr, $prepay_id)
    {
        $str = $appid . "\n" . $timeStamp . "\n" . $noncestr . "\n" . $prepay_id . "\n";
        $key = file_get_contents(root_path() . '/vendor/path/apiclient_key.pem');//在商户平台下载的秘钥
        $str = $this->getSha256WithRSA($str, $key);
        return $str;
    }

    /**
     * 申请退款API
     * @$name   订单商品名称
     * @$out_trade_no   订单号
     * @$money   订单退款金额
     * @$transaction_id  微信支付成功的流水单号
     */
    public function refundOrders($name, $out_trade_no, $transaction_id,$money)
    {
        $mchid = env('WECHAT.mch_id');  // 商户号
        $xlid = env('WECHAT.serial_number'); //API序列号
        $url = "https://api.mch.weixin.qq.com/v3/refund/domestic/refunds";
        $urlarr = parse_url($url);
        $data['transaction_id'] = $transaction_id; //原支付交易对应的微信订单号。
        $data['out_refund_no'] = $out_trade_no; //退款单号
        $data['reason'] = "订单". $name ."的退款"; //退款原因 非必填
        $data['notify_url'] = env('REFUND_NOTIFY_URL'); //退款回调接口
        $data['amount']['refund'] = $money; //退款金额（只能小于等于支付金额）
        $data['amount']['total'] = $money; //退款金额（只能小于等于支付金额）
        $data['amount']['currency'] = "CNY"; //金额类型
        $randstr = getrandstr(16); //随机字符串长度不超过32
        $time = time();
        $data = json_encode($data);
        $key = $this->getSign($data, $urlarr['path'], $randstr, $time); //签名
        $token = sprintf('mchid="%s",serial_no="%s",nonce_str="%s",timestamp="%d",signature="%s"', $mchid, $xlid, $randstr, $time, $key);//头部信息
        $header = array(
            'Content-Type:' . 'application/json; charset=UTF-8',
            'Accept:application/json',
            'User-Agent:*/*',
            'Authorization: WECHATPAY2-SHA256-RSA2048 ' . $token
        );
        $ret = $this->curl_post_https($url, $data, $header);
        $ret = json_decode($ret, true);
        return $ret;
    }




    /*
     * 签名方法
     * */
    public function getSha256WithRSA($content, $privateKey)
    {
        $binary_signature = "";
        $algo = "SHA256";
        openssl_sign($content, $binary_signature, $privateKey, $algo);
        $sign = base64_encode($binary_signature);
        return $sign;
    }

    /*
    * 微信支付回调
    * */
    public function payment_notify($request)
    {
        $input_data = $request->param();
        $key = env('WECHAT.key');//商户平台设置的api v3 密码
        $text = base64_decode($input_data['resource']['ciphertext']); //解密
        /* =========== 使用V3支付需要PHP7.2.6安装sodium扩展才能进行解密参数  ================ */
        $str = sodium_crypto_aead_aes256gcm_decrypt($text, $input_data['resource']['associated_data'], $input_data['resource']['nonce'], $key);
        $res = json_decode($str, true);
        if ($res['trade_state'] == 'SUCCESS') {
            Db::startTrans();
            try {
                /* 成功操作 */
                Db::commit();
                $a = array(
                    "code" => "SUCCESS",
                    "message" => "成功"
                );
                return json_encode($a);
            } catch (\Exception $e) {
                Db::rollback();
                $a = array(
                    "code" => "ERROR",
                    "message" => "失败"
                );
                return json_encode($a);
            }
        }
        $a = array(
            "code" => "ERROR",
            "message" => "失败"
        );
        return json_encode($a);
    }

    /*
     * 微信退款回调
     * */
    public function refund_notify($request)
    {
        $input_data = $request->param();
        $key = env('WECHAT.key');//商户平台设置的api v3 密码
        $text = base64_decode($input_data['resource']['ciphertext']);
        /* =========== 使用V3支付需要PHP7.2.6安装sodium扩展才能进行解密参数  ================ */
        $str = sodium_crypto_aead_aes256gcm_decrypt($text, $input_data['resource']['associated_data'], $input_data['resource']['nonce'], $key);
        $res = json_decode($str, true);
        if ($res['refund_status'] == 'SUCCESS') {
            Db::startTrans();
            try {
                /*回调处理逻辑内容*/
                Db::commit();
                $a = array(
                    "code" => "SUCCESS",
                    "message" => "成功"
                );
                return json_encode($a);
            } catch (\Exception $e) {
                Db::rollback();
                $a = array(
                    "code" => "ERROR",
                    "message" => "失败"
                );
                return json_encode($a);
            }
        }
        $a = array(
            "code" => "ERROR",
            "message" => "失败"
        );
        return json_encode($a);
    }





}
