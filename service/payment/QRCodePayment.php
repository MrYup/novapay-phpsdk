<?php

/**
 * 二维码代收
 */
class QRCodePayment extends \Payment
{



    /**
     * 创建二维码代收订单
     * @param $paymentAppId    -代付appID
     * @param ...$params
     * @return void
     */
    public function create($paymentAppId,...$params){
        $body = [
            'mchOrderNo' => 'YourMerchantOrderNo' . rand(1,10000000),
            'amount' => "100000",
            'currency' => 'PHP',
            'appId' => $paymentAppId,
            'expireSeconds' => 86400,
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

        $result = $this->instance->hitEndpoint('/payment/qrcode/create',$body);
        print_r($result);
    }

    /**
     * 二维码订单查询
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

        $result = $this->instance->hitEndpoint('/payment/qrcode/get',$body);
        print_r($result);
    }


}