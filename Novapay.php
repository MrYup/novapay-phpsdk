<?php


class Novapay
{

    private $privateKey;
    private $mchId;
    private $hostname;

    /**
     * @var static
     */
    private static $instance;

    private function __construct()
    {
        $config = include './config.php';

        $this->mchId = $config['merchantId'];
        $this->privateKey = self::formatPriKey($config['mchRsrPriKeyString']);
        $this->hostname = $config['hostname'];
    }

    /**
     * @param ...$params
     * @return mixed|static
     */
    public static function make(){

        if (!isset(self::$instance)){
            self::$instance = new static();
        }
        return self::$instance;
    }




    /**
     * 格式化私钥
     * @param $priKey
     * @return string
     */
    public static function formatPriKey($priKey){
        return "-----BEGIN PRIVATE KEY-----\n" . wordwrap($priKey, 64, "\n", true) . "\n-----END PRIVATE KEY-----";
    }

    /**
     * 格式化公钥
     * @param $pubKey
     * @return string
     */
    public static function formatPubKey($pubKey){
        return "-----BEGIN PUBLIC KEY-----\n" . wordwrap($pubKey, 64, "\n", true) . "\n-----END PUBLIC KEY-----";
    }

    /**
     * 升级ksort()，如果元素是数组，那么元素也将以相同的方式ksort()
     * @param $arr
     * @param $flag
     * @return void
     */
    public static function ksortInDeep(&$arr, $flag = SORT_REGULAR){
        foreach ($arr as $k => $v){
            if (is_array($v)){
                //元素是数组，排序
                self::ksortInDeep($v,$flag);
                $arr[$k] = $v;
            }else{
                //元素是null，转空字符串
                $v = is_null($v)?'':$v;
                //元素是bool，转对应的0或1
                $v = is_bool($v)?(int)$v:$v;

                $arr[$k] = $v;
            }
        }
        ksort($arr,$flag);
    }

    /**
     * RSA私钥签名
     * @param $string       -待签名串
     * @param $privateKey   -私钥
     * @return string
     */
    public  function buildSignature($string){
        $privatekey = openssl_get_privatekey($this->privateKey);
        openssl_sign($string, $result, $privatekey, OPENSSL_ALGO_SHA256);
        return base64_encode($result);
    }

    /**
     * RSA公钥验签
     * @param $string       -待签名串
     * @param $signature    -签名
     * @param $publicKey    -公钥
     * @return bool
     */
    public static function verifySignature($string, $signature, $publicKey){
        $publicKey = openssl_get_publickey(self::formatPubKey($publicKey));
        return openssl_verify($string, base64_decode($signature), $publicKey, OPENSSL_ALGO_SHA256) == 1;
    }

    public function hitEndpoint($uri,array $body,$method = 'POST'){
        //13位时间戳
        $timestamp = round(microtime(true) * 1000);

        //ASCII升序
        self::ksortInDeep($body);
        $payload = json_encode($body,JSON_UNESCAPED_SLASHES);

        //签名明文串
        $signString = implode('.',[$method,$uri,$this->mchId,$timestamp,$payload]);
        $signature = self::buildSignature($signString);

        $url = $this->hostname . $uri;

        //请求头
        $headers = [
            "Content-Type:application/json",
            "X-TIMESTAMP:".$timestamp,
            "X-MERCHANT-ID:{$this->mchId}",
            "X-SIGNATURE:".$signature,
            "X-B3-TraceId:" . time() . '-'. rand(100000,10000000),
        ];

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_POSTFIELDS =>$payload,
            CURLOPT_HTTPHEADER => $headers,
        ));

        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $curlNo = curl_errno($curl);
        $curlError = curl_error($curl);
        curl_close($curl);


        return compact('url'
            ,'headers'
            ,'payload'
            ,'method'
            ,'response'
            ,'httpCode'
            ,'curlNo'
            ,'curlError'
        );
    }

}

