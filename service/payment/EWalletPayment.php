<?php

/**
 * 电子钱包代收
 */
class EWalletPayment extends \Payment
{



    /**
     * 创建电子钱包的付款链接
     * @param $paymentAppId    -代付appID
     * @param ...$params
     * @return void
     */
    public function create($paymentAppId,...$params){
        $body = [
            'mchOrderNo' => 'YourMerchantOrderNo' . rand(1,10000000),
            'minAmount' => "100000",
            'maxAmount' => "100000",
            'isSingleUsed' => 1,
            'currency' => 'PHP',
            'bankCode' => 'GCASH',
            'appId' => $paymentAppId,
            'expireSeconds' => 86400,
            'osType' => 'ANDROID',//GCAS 必填
            'terminalType' => 'APP',
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

        $result = $this->instance->hitEndpoint('/payment/ewallet/create',$body);
        print_r($result);
    }

    /**
     * 电子钱包订单查询
     * @param $onFilter
     * @param $onValue
     * @param $page
     * @param $pageSize
     * @param $startTime
     * @param $endTime
     * @return void
     */
    public function query($onFilter,$onValue,$page = 1,$pageSize = 50 , $startTime = '',$endTime = ''){
        $body = compact('onFilter','onValue');

        $result = $this->instance->hitEndpoint('/payment/ewallet/get',$body);
        print_r($result);
    }

}