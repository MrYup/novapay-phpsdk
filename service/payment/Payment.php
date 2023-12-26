<?php

/**
 * 通用代收
 */
class Payment
{

    /**
     * @var \Novapay
     */
    protected $instance;

    public function __construct($instance)
    {
        $this->instance = $instance;
    }

    /**
     * 创建订单
     * @param $paymentAppId
     * @param ...$params
     */
    public function create($paymentAppId,...$params){
        $body = [
            'mchOrderNo' => 'YourMerchantOrderNo' . rand(1,10000000),
            'minAmount' => "50000",
            'maxAmount' => "100000",
            'currency' => 'PHP',
            'bankCode' => 'GCASH',
            'osType' => 'ANDROID',//GCAS 必填
            'terminalType' => 'APP',
            'isSingleUsed' => 1,
            'appId' => $paymentAppId,
            'options' => [
                'userInfo' => [
                    'birthday' => '',
                    'firstName' => 'Manila',
                    'lastName' => 'Lucky',
                    'address' => '165 Valley View Rd, Hillside, NJ 07205 US',
                    'email' => 'username@gmail.com',
                    'userMobile' => '639053005108',
                ],
                'userAddress' => [
                    'city' => 'New York',
                    'state' => 'New York State',
                    'address' => '165 Valley View Rd, Hillside, NJ 07205 US',
                ],
                'companyInfo' => [
                    'firstName' => 'Hotel',
                    'lastName' => 'Hillside',
                    'address' => '',
                ],
            ],
            'customExtra' => [
                'userId' => 123,
                'othersInfo' => 'xxxx',
            ],
        ];

        return $this->instance->hitEndpoint('/payment/create',$body);
    }

    /**
     * 查询订单
     * @param $onFilter
     * @param $onValue
     * @param $page
     * @param $pageSize
     * @param $startTime
     * @param $endTime
     */
    public function query($onFilter,$onValue,$page = 1,$pageSize = 50 , $startTime = '',$endTime = ''){
        $body = compact('onFilter','onValue','page','pageSize','startTime','endTime');

        return $this->instance->hitEndpoint('/payment/get',$body);
    }
}