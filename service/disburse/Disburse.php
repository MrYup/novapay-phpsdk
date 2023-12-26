<?php

/**
 * 通用代付
 */
class Disburse
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
     * 创建代付订单，根据文档描述传参需要
     * @param $disburseAppId    -代付appID
     * @param ...$params
     */
    public function create($disburseAppId,...$params){
        $body = [
            'mchOrderNo' => 'YourMerchantOrderNo' . rand(1,10000000),
            'businessOrderNo' => rand(1,10000) . '-HasMany-mchOrderNo',
            'amount' => "10000",
            'currency' => 'PHP',
            'bankCode' => 'RBMI',
            'paymentMethod' => 3,
            'bankCard' => '09053005108',
            'userName' => 'Manila Lucky',
            'userMobile' => '639053005107',
            'appId' => $disburseAppId,
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

        return $this->instance->hitEndpoint('/disburse/create',$body);
    }

    /**
     * 查询代付订单，查询订单
     * @param $onFilter
     * @param $onValue
     */
    public function query($onFilter,$onValue){
        $body = compact('onFilter','onValue');

        return $this->instance->hitEndpoint('/disburse/get',$body);
    }

    /**
     * 取消订单
     * @param $onFilter
     * @param $onValue
     * @return mixed
     * @throws Exception
     */
    public function cancel($onFilter,$onValue){
        throw new Exception("Order Not cancelable");
    }

}